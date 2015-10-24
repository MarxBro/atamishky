#!/usr/bin/perl
###########################################
# Compresor js perlistico.
###########################################
use strict;
use Getopt::Std;
use autodie;
use JavaScript::Packer;

my %opts = ();
getopts('i:o:',\%opts);

my $packer = JavaScript::Packer->init();

open( UNCOMPRESSED, $opts{i} );    # 'ajax.src.js'
open( COMPRESSED, '>', $opts{o});  # 'ajax.js'

my $js = join( '', <UNCOMPRESSED> );

$packer->minify( \$js, { compress => 'clean' } );

print COMPRESSED $js;
close(UNCOMPRESSED);
close(COMPRESSED);
exit 0;
