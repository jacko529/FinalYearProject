<?php

require_once 'vendor/autoload.php';
require_once 'CreateUsers.php';

//
$connect = new CreateUsers('jack',
                            'churchill',
                            'churchillj54@gmail.com',
                            '$argon2id$v=19$m=65536,t=4,p=1$Gn18XYicsjHk9o55b89nsw$6neybkuZdl5/4rhWn4yTXnwLELVBX8DPyej7xGDSQ94',
                            8,"['ROLE_USER','ROLE_TEACHER']");


$connect->createUser();
//$connect->deleteAll();
//$connect->addConstraint();
//for ($i = 0; $i < 1; $i++) {
//    $connect->createUser();
//    $connect->learningStyle();
//    $connect->connectCourse();
//}

//
//$match = new MatchUser();
//
////$mo = $match->checkStage("global stage 2");
////$stage = $mo->getRecords();
////foreach($stage as $mod){
////    $new = $mod->value('stage');
////}
$names = [
    "koepp.samanta@boyer.com"	,
    "albin94@gmail.com"	,
    "slangworth@yahoo.com"	,
    "johnathan.smitham@cummerata.com"	,
    "kuhic.retha@krajcik.net"	,
    "dan07@berge.biz"	,
    "jonas.kuhlman@greenholt.biz"	,
    "armstrong.edna@swift.info"	,
    "leffler.birdie@ritchie.com"	,
    "jovani91@lynch.com"	,
    "qmacejkovic@bogisich.biz"	,
    "miller.roberta@bailey.com"	,
    "stoltenberg.emmie@gmail.com"	,
    "eula.bahringer@ortiz.com"	,
    "thompson.braden@hotmail.com"	,
    "dayana.skiles@harvey.com"	,
    "heathcote.haskell@bayer.com"	,
    "theodore.jenkins@hotmail.com"	,
    "oceane.runolfsdottir@yahoo.com"	,
    "thurman19@hotmail.com"	,
    "hilpert.winifred@hotmail.com"	,
    "maci15@hotmail.com"	,
    "hthompson@hotmail.com"	,
    "oweber@gulgowski.com"	,
    "gottlieb.weldon@murray.com"	,
    "skoch@gmail.com"	,
    "heller.dangelo@gmail.com"	,
    "mozelle.gutkowski@gmail.com"	,
    "lmills@thompson.org"	,
    "qdooley@hotmail.com"	,
    "gfeil@gmail.com"	,
    "otha03@hotmail.com"	,
    "trinity.zieme@gmail.com"	,
    "magdalen98@hammes.com"	,
    "weber.tabitha@yahoo.com"	,
    "mcglynn.ara@gmail.com"	,
    "considine.lenore@hotmail.com"	,
    "claude51@hotmail.com"	,
    "xconnelly@hintz.org"	,
    "susana86@balistreri.com"	,
    "erwin.langworth@yahoo.com"	,
    "reichert.victoria@beahan.com"	,
    "mcdermott.mossie@zboncak.com"	,
    "roy71@hotmail.com"	,
    "jerry75@yost.net"	,
    "herzog.eusebio@yahoo.com"	,
    "garry04@gmail.com"	,
    "mann.helmer@abbott.info"	,
    "roderick.ohara@yahoo.com"	,
    "hauck.nathanial@gmail.com"	,
    "judah.rau@gmail.com"	,
    "tiara93@gmail.com"	,
    "ed88@erdman.net"	,
    "schoen.forest@yahoo.com"	,
    "antonio.pfeffer@yahoo.com"	,
    "golda67@yahoo.com"	,
    "white.jana@gmail.com"	,
    "brando.johnson@borer.info"	,
    "graciela65@gmail.com"	,
    "ekemmer@crona.net"	,
    "istokes@hotmail.com"	,
    "jamie.bailey@hotmail.com"	,
    "zella24@gmail.com"	,
    "lindgren.briana@gmail.com"	,
    "kenneth.stokes@torphy.org"	,
    "shad31@fay.com"	,
    "mariam56@luettgen.info"	,
    "churchillj54@gmail.com"	,
    "rupert05@hirthe.net"	,
    "kasey96@becker.com"	,
    "jayde.davis@graham.net"	,
    "nicolas83@yahoo.com"	,
    "gwill@gmail.com"	,
    "celestine.bartoletti@luettgen.com"	,
    "kaylah66@yahoo.com"	,
    "laurel.crona@ruecker.biz"	,
    "lillian20@roob.biz"	,
    "jillian65@fadel.org"	,
    "mante.kaela@gutmann.com"	,
    "kamille66@wisozk.org"	,
    "pdaniel@prosacco.com"	,
    "vivien.lynch@hotmail.com"	,
    "kfeil@oconnell.info"	,
    "emory.berge@gmail.com"	,
    "avis60@jones.info"	,
    "tgleichner@gmail.com"	,
    "sdavis@von.net"	,
    "hellen.nitzsche@hotmail.com"	,
    "weimann.leopold@gmail.com"	,
    "bernie94@wisoky.net"	,
    "ratke.veronica@gmail.com"	,
    "iva.bogisich@gmail.com"	,
    "adriana.predovic@hotmail.com"	,
    "nelle31@yahoo.com"	,
    "kaden01@grant.com"	,
    "ihalvorson@hammes.com"	,
    "arch83@schamberger.com"	,
    "eldridge.cruickshank@gmail.com"	,
    "vinnie73@yahoo.com"	,
    "donato.leuschke@weimann.com"	,
    "micaela54@collier.biz"	,
    "yazmin.hermann@gmail.com"	,
    "cbrown@yahoo.com"	,
    "felton.king@gmail.com"	,
    "evans.kling@gmail.com"	,
    "fdonnelly@gmail.com"	,
    "arely.mcglynn@gmail.com"	,
    "bennie34@spinka.com"	];
//
//foreach($names as $name){
//        $match->match($name );
//}
//
//
//
//
//
//
//
//
//
//
//
//
//$resources  = [
//
//
//
//];



