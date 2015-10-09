my @entities_bare=qw/&(?!\w{2,4};) " ' < >/;
my @entities_encoded=qw/&amp; &quot; &apos; &lt; &gt;/;

my $r = encode_entities ( $ARGV[0] );
print $r;

sub encode_entities {
    my $string=shift;
    print "trace: in encode_entities\n";
    for(my $n=0;$n<scalar @entities_bare;++$n){
        print "encode_entities: searching for ".$entities_bare[$n]." to replace with ".$entities_encoded[$n]."...\n";
        if(not $string=~s/$entities_bare[$n]/$entities_encoded[$n]/g){
            print "encode_entities: WARNING: found no entites for ".$ entities_bare[$n].".\n";
        }
        $string =~ s/$entities_bare[$n]/$entities_encoded[$n]/gie;
    }
    return $string;
}
