#!/usr/bin/perl
######################################################################
# csv2xml :: 
# Transform a stupid csv into something even more stupid: XML !
######################################################################
use strict;
use autodie;
use feature             "say";
use Getopt::Std;
use Pod::Usage;
use File::Slurp;
use Text::Capitalize    "capitalize"; # ahorra algo de tiempo

my %opts = ();
getopts( 'hdcto:f:', \%opts );

my $debug = $opts{d} || 0;
my $archivo_in = $opts{f};
ayudas() unless $archivo_in;

if ($opts{h}){
    ayudas();    
}

my @csv_lns = read_file( "$archivo_in", binmode => ':utf8' );
my $padre_del_xml = 'entries';
my $index     = 837;
my $TUTTI_XML = '<' . $padre_del_xml . '>' . "\n";

my @filter_tags = qw/según sobre hasta luego contra/;
my $rgx_filter_tags = join (q'|', @filter_tags);

# para codificar las entidades: funcionó mejor regexearlo que usar XML::Entities.
my @entities_bare          = qw/&(?!\w{2,4};) " ' < >/;
my @entities_bare_txt_pass = qw/& " ' < >/;
my @entities_encoded       = qw/&amp; &quot; &apos; &lt; &gt;/;

my $catalogo_txt = ''; # berreta.

foreach my $ln_csv_raw (@csv_lns){
#saltearse la linea de encabezados.
    next if ($ln_csv_raw =~ m/^tipo\|/i);
    chomp($ln_csv_raw);
    my $ln_csv         = encode_some_shitty_entities($ln_csv_raw);

    my @campos = split /\|/, $ln_csv;

#Estos campos son directos.
    my $tipo            = $campos[0];
    my $titulo          = sacar_punto_del_final($campos[1]);
    my $editorial       = $campos[3] || "none";
    my $agno            = $campos[4] || "none";
    my $city            = $campos[5];

#estos necesitan atencion
    my $bibliografia    = $campos[6] || "none";
    my $link            = $campos[7] || "none";
    my $soporte         = $campos[8] || "none";
    my $descripcion     = $campos[9] || "none";

#salida a un mugroso txt.
#author . titulo . editorial . ciudad , año
    my $autores_txt = $campos[2];
    my $catalogo_txt_add = join('. ',$autores_txt,$titulo,$editorial,$city);
    $catalogo_txt_add .= ', ' . $agno . '.';
    $catalogo_txt .= decode_some_shitty_entities($catalogo_txt_add);
    $catalogo_txt .= "\n";

    unless ( $bibliografia eq 'none' ) {
        my $apr =
            "\t" . '<bibliografia>' . $bibliografia . '</bibliografia>' . "\n";
        $bibliografia = $apr;
    }
    unless ( $link eq 'none' ) {
        my $apl = "\t" . '<link>' . $link . '</link>' . "\n";
        $link = $apl;
    }
    unless ( $agno eq 'none' ) {
        my $apy = "\t" . '<year>' . $agno . '</year>' . "\n";
        $agno = $apy;
    }
    unless ( $soporte eq 'none' ) {
        my $aps = "\t" . '<soporte>' . $soporte . '</soporte>' . "\n";
        $soporte = $aps;
    }
    unless ( $descripcion eq 'none' ) {
        my $apv =
            "\t" . '<descripcion>' . $descripcion . '</descripcion>' . "\n";
        $descripcion = $apv;
    }
    unless ( $editorial eq 'none' ) {
        my $tapv = "\t" . '<publisher>' . $editorial . '</publisher>' . "\n";
        $editorial = $tapv;
    }

#son keywords todas las palabras del titulo de mas de 4 letras.
    my $keywords = make_keywords($titulo);

#Los autores son un quilombo,
    my $autores         = make_authors($campos[2]);

# Index unico e irrepetible para el nombre de la entrada... chiotto.
    my $nombre = $tipo . '2015-' . $index ;

#Esta cabeceada evita quilombos 
my $esqueleto_entry = 
'<entry name="@@NOMBRE@@">
    <entrytype>@@TIPO@@</entrytype>
    <title>@@TITULO@@</title>
    @@AGNO@@
    <address>@@CIUDAD@@</address>
    @@EDITORIAL@@
    @@KEYWORDS@@
    @@AUTORES@@
    @@BIBLIOGRAFIA@@
    @@LINK@@
    @@SOPORTE@@
    @@DESCRIPCION@@
</entry>
';
   
   $esqueleto_entry =~ s/\@\@NOMBRE\@\@/$nombre/gi; 
   $esqueleto_entry =~ s/\@\@TITULO\@\@/$titulo/gi; 
   $esqueleto_entry =~ s/\@\@TIPO\@\@/$tipo/gi; 
   $esqueleto_entry =~ s/\@\@AGNO\@\@/$agno/gi; 
   $esqueleto_entry =~ s/\@\@CIUDAD\@\@/$city/gi; 
   $esqueleto_entry =~ s/\@\@EDITORIAL\@\@/$editorial/gi; 
   $esqueleto_entry =~ s/\@\@BIBLIOGRAFIA\@\@/$bibliografia/gi;
   $esqueleto_entry =~ s/\@\@AUTORES\@\@/$autores/gi; 
   $esqueleto_entry =~ s/\@\@LINK\@\@/$link/gi;
   $esqueleto_entry =~ s/\@\@KEYWORDS\@\@/$keywords/gi;
   $esqueleto_entry =~ s/\@\@SOPORTE\@\@/$soporte/gi;
   $esqueleto_entry =~ s/\@\@DESCRIPCION\@\@/$descripcion/gi;

   $esqueleto_entry =~ s/none//gi; # Esto vuela las etiquetas vacias.
   
   # mejorado escapando entidades xml arriba, con el switch e.
   # $esqueleto_entry =~ s/\'/ /gi;  

   $index++;

   my @fix = split /\n/, $esqueleto_entry;
   my $fix_string = join ("\n", grep { /</ } @fix
   );
   print $fix_string if $debug;

   #$TUTTI_XML .= $esqueleto_entry;
   $TUTTI_XML .= $fix_string . "\n";


}

$TUTTI_XML .= '</' . $padre_del_xml . '>';
if ($opts{c}){
    print compactar($TUTTI_XML);
    exit  0;
}
print $TUTTI_XML unless $opts{o};
write_file("$opts{o}",{ binmode => ':utf8' }, $TUTTI_XML) if $opts{o}; 
write_file("catalogo.txt",{ binmode => ':utf8' }, $catalogo_txt) if $opts{t}; 
exit 0;

######################################################################
# Subs
######################################################################
sub ayudas {
    pod2usage(-verbose=>3);
    exit;
}

sub make_keywords {
    my $t = shift;
    my @palabras = grep { length > 4 } split ' ', $t;
    my $gf = '<keywords>' . "\n";
    foreach my $gypa (@palabras){
        my $gy = lc($gypa);
        chomp($gy);
        next if ($gy =~ /\&/);
        $gy =~ s/^ //g;
        $gy =~ s/ $//g;
        $gy =~ s/\,$//g;
        $gy =~ s/\;$//g;
        $gy =~ s/\:$//g;
        $gy =~ s/\.$//g;
        $gy =~ s/\.+//g;
        # Agregado: sacar caracteres innecesarios y numeros
        $gy =~ s/\(//g;
        $gy =~ s/\)//g;
        $gy =~ s/\-//g;
        $gy =~ s/\d+//g;
        # Agregado: comprobar nuevamente si la longitud sigue siendo > 4
        next if (length($gy) <= 4);
        # Agregado sacar preposiciónes
        next if ($gy =~ /$rgx_filter_tags/g);
        my $str = "\t" . '<keyword>' . $gy . '</keyword>' . "\n"; 
        $gf .= $str;
    }
    $gf .= "\t" . '</keywords>';
    return $gf;
}

sub make_authors {
    my $st = shift; 
    my @autores = split /; /, $st;
    my $finalputos = '<authors>'  . "\n";
    foreach my $au (@autores){
        chomp($au);
        lc($au);
        capitalize($au);
        $au =~ s/^ //g;
        $au =~ s/ $//g;
        $au =~ s/\.$//g;
        my $uylaputa = "\t" . '<author>' . $au . '</author>' . "\n";
        $finalputos .= $uylaputa;
    }
    $finalputos .= "\t" . '</authors>';
    return $finalputos;   
}

sub compactar {
    my $input   = shift;
    $input      =~ tr/\t//d;
    $input      =~ tr/\n//d;
    $input      =~ s/>\s+</></g;
    return $input;
}

sub encode_some_shitty_entities {
    my $string = shift;
    for(my $n=0;$n<scalar @entities_bare;++$n){
        $string =~ s/$entities_bare[$n]/$entities_encoded[$n]/gie;
    }
    return $string;
}

sub decode_some_shitty_entities {
    my $stringy = shift;
    for(my $ni=0;$ni<scalar @entities_encoded;++$ni){
        $stringy =~ s/$entities_encoded[$ni]/$entities_bare_txt_pass[$ni]/gie;
    }
    return $stringy;
}

sub sacar_punto_del_final{
    my $sting = shift;
    $sting =~ s/\.$//g;
    return $sting;
}


=pod

=encoding utf8

=head1 SYNOPSIS

Script para generar XML valido desde archivos csv, para utilizarlo
como catalogo o indice de la bibliografia de Atamishky.

=head2 Forma de uso:

=over

=item B<c>         Salida compacta : sin saltos de linea, ni espacios.

=item B<f>         Archivo input : Ver debajo sobre el formato (csv),

=item B<o>         Archivo Output : Opcional, por defecto STDOUT.

=item B<t>         Archivo txt: genera "catalogo.txt" desde el csv.

=item B<h>         (Esta) Ayuda.

=item B<d>         Debug.

=back

=head1 Archivo en la entrada

El archivo csv tiene que respetar en su encabezado, el siguiente orden:

* tipo
* titulo
* autores
* editorial
* año
* ciudad
* bibliografia
* link
* soporte
* descripcion

Los valores en todo el csv se separan con la pipa B<|>.

=head3 tipos

Los tipos posibles son :

* musica
* video
* book
* misc

=head3 Autores

Si la entrada tiene mas de un autor, separar con punto y coma.

No poner "y" al final, la plantilla se encarga de eso.

=head3 valores vacios

Si no hay bibliografia o link que poner, no poner nada.

=head3 Soporte

El campo soporte solo tiene sentido si el tipo de entrada es igual a video.

=head3 Salidas

Manejar las salidas a gusto, xml, txt y stdout son las opciones.

Estaba a punto de programar algo que lo convierta a pdf pero es un gasto 
innecesario de energia, pasarlo a un txt es mucho mas util calculo.

Para todo lo demas existe pandoc.

=head1 Autor y Licencia.

Programado por B<Marxbro> aka B<Gstv>, ditribuir solo bajo la licencia
WTFPL: I<Do What the Fuck You Want To Public License>.

Zaijian.

=cut




