<?php

require_once 'vendor/autoload.php';
require_once 'CreateUsers.php';

//


//$connect->createUser();
//$connect->deleteAll();
//$connect->addConstraint();
//for ($i = 0; $i < 350; $i++) {
//    $connect = new CreateUsers();
//    $connect->createUser();
//    $connect->learningStyle();
//    $connect->connectCourse();
//    sleep(3);
//}

//
$match = new CreateUsers();
$match->deleteAll();
$match->test();
$match->addConstraint();
$match->addConstraints();
//$mo = $match->checkStage("global stage 2");
//$stage = $mo->getRecords();
//foreach($stage as $mod){
//    $new = $mod->value('stage');
//}


//
//$newarray = [
//    "gswaniawski@hotmail.com",
//    "justyn11@gmail.com",
//    "brionna70@yahoo.com",
//    "marisol86@prosacco.com",
//    "nora.effertz@yahoo.com",
//    "berge.verla@gmail.com",
//    "jwilliamson@hotmail.com",
//    "hwest@schowalter.net",
//    "hipolito95@spinka.com",
//    "oberbrunner.anna@weissnat.com",
//    "abashirian@gleichner.com",
//    "hwolf@bernhard.com",
//    "grant.kolby@hudson.com",
//    "ahmed.thompson@gmail.com",
//    "karli.kessler@yahoo.com",
//    "qfunk@gmail.com",
//    "klein.elton@keeling.info",
//    "zboncak.verla@hotmail.com",
//    "ykoepp@grady.com",
//    "vcruickshank@hoppe.com",
//    "pfeffer.rafaela@yahoo.com",
//    "ydouglas@gmail.com",
//    "littel.archibald@kassulke.com",
//    "modesta.hessel@romaguera.com",
//    "nschaden@kuphal.com",
//    "earnestine.kuhn@hotmail.com",
//    "martin30@monahan.com",
//    "tvandervort@hayes.com",
//    "white.demarco@kihn.com",
//    "murazik.tyreek@hotmail.com",
//    "nstamm@yahoo.com",
//    "mollie.nicolas@yahoo.com",
//    "pwilliamson@yahoo.com",
//    "luettgen.selena@gmail.com",
//    "leannon.hertha@yahoo.com",
//    "bcummerata@greenfelder.net",
//    "jwisozk@kovacek.com",
//    "toy.omer@hotmail.com",
//    "christian.quitzon@gmail.com",
//    "alexa.bayer@sanford.net",
//    "kallie.spencer@crist.com",
//    "hellen.hammes@gottlieb.com",
//    "hackett.darron@yahoo.com",
//    "torp.jannie@rodriguez.com",
//    "muriel65@ebert.biz",
//    "camille13@yahoo.com",
//    "rmclaughlin@sauer.com",
//    "tturner@brakus.com",
//    "carter.burley@yahoo.com",
//    "johnnie.brown@hotmail.com",
//    "elvera.aufderhar@heidenreich.com",
//    "roxane.renner@yahoo.com",
//    "cameron.parker@rau.com",
//    "vrau@schmidt.com",
//    "brycen78@hotmail.com",
//    "breitenberg.june@gmail.com",
//    "ikoepp@hotmail.com",
//    "treynolds@toy.biz",
//    "parker.jordyn@hotmail.com",
//    "deffertz@hotmail.com",
//    "beverly.blanda@gmail.com",
//    "zaria90@yahoo.com",
//    "hnienow@yahoo.com",
//    "schmidt.rebeca@prosacco.com",
//    "shemar12@cronin.info",
//    "kris.timmy@rice.info",
//    "lynch.javon@gmail.com",
//    "nschiller@hodkiewicz.com",
//    "augusta48@frami.net",
//    "janae.feil@yahoo.com",
//    "senger.vicente@lesch.com",
//    "matilde42@herzog.com",
//    "kobe.parker@hotmail.com",
//    "xskiles@hotmail.com",
//    "bernardo.schoen@gmail.com",
//    "bauch.jada@hermiston.com",
//    "akeem68@eichmann.net",
//    "mschaefer@morissette.com",
//    "gspinka@gmail.com",
//    "qlueilwitz@gmail.com",
//    "carlee.lesch@satterfield.com",
//    "macejkovic.dariana@anderson.com",
//    "trent13@yahoo.com",
//    "mckenzie.earnest@gmail.com",
//    "ebert.minnie@bayer.com",
//    "alessandra.reichel@braun.com",
//    "graham.ned@schimmel.com",
//    "lucile.hickle@gmail.com",
//    "cwolf@gmail.com",
//    "cyril.hintz@yahoo.com",
//    "iratke@gmail.com",
//    "kozey.preston@brown.com",
//    "lschumm@ernser.com",
//    "dax.hoeger@gmail.com",
//    "stamm.abigail@dietrich.com",
//    "dakota.franecki@yahoo.com",
//    "rosemary.lemke@yahoo.com",
//    "carolanne.jaskolski@yahoo.com",
//    "pdickens@hotmail.com",
//    "wcarter@hotmail.com",
//    "oconner.zakary@gmail.com",
//    "camille35@yahoo.com",
//    "margaret.mann@upton.com",
//    "dklein@yahoo.com",
//    "tlegros@rempel.biz",
//    "stark.rylee@gmail.com",
//    "grodriguez@beier.com",
//    "daniela42@hotmail.com",
//    "caleigh.gorczany@hotmail.com",
//    "kelton.hintz@gmail.com",
//    "aletha.white@mcdermott.net",
//    "mswift@romaguera.net",
//    "odenesik@nitzsche.com",
//    "laisha.kuhlman@gmail.com",
//    "mflatley@stokes.info",
//    "laverna.marks@ward.com",
////    "balistreri.kaitlin@gmail.com",
////    "funk.ted@gmail.com",
////    "vita56@lueilwitz.com",
////    "brandyn.bode@gmail.com",
////    "upton.adolphus@hotmail.com",
////    "daniela.berge@ruecker.info",
////    "margaret.berge@bosco.com",
////    "pdare@abbott.com",
////    "kozey.trisha@wisozk.com",
////    "eliza.greenfelder@gleason.info",
////    "julia79@marvin.com",
////    "susan.lemke@kuphal.com",
////    "toy.mariane@stoltenberg.org",
////    "rodriguez.monserrate@hotmail.com",
////    "ewell.miller@senger.biz",
////    "berniece56@lang.com",
////    "frederick.johnston@witting.com",
////    "lela.lemke@grimes.biz",
////    "terrell56@yahoo.com",
////    "simone04@gmail.com",
////    "osborne59@huel.org",
////    "chauncey57@hirthe.org",
////    "alena46@monahan.com",
////    "stacy.labadie@gmail.com",
////    "arden41@hotmail.com",
////    "easton.lueilwitz@hotmail.com",
////    "ybradtke@gmail.com",
////    "frederick67@yahoo.com",
////    "keebler.olen@okeefe.info",
////    "lon84@hotmail.com",
////    "ryann38@hotmail.com",
////    "merlin65@hotmail.com",
////    "rhianna40@morissette.com",
////    "wisoky.rebecca@oconner.info",
////    "rosa59@hotmail.com",
////    "zbraun@gmail.com",
////    "tomasa.kunde@hotmail.com",
////    "bfarrell@hotmail.com",
////    "beatrice73@hotmail.com",
////    "ryan.hollie@yahoo.com",
////    "reyes.lynch@hotmail.com",
////    "laufderhar@borer.info",
////    "justice33@friesen.com",
////    "mckenzie.jovanny@lowe.com",
////    "vicky.larson@gmail.com",
////    "rebeca90@hotmail.com",
////    "alexane01@hotmail.com",
////    "ara.crist@hotmail.com",
////    "klocko.emelia@yahoo.com",
////    "creola.hammes@hotmail.com",
////    "terrence67@yahoo.com",
////    "frieda.king@greenholt.com",
////    "damaris82@vonrueden.info",
////    "emmy.wisozk@gmail.com",
////    "carissa.parisian@grimes.com",
////    "carter.nella@yahoo.com",
////    "fritsch.wilfrid@yahoo.com",
////    "william16@yahoo.com",
////    "dora71@balistreri.net",
////    "izabella27@von.com",
////    "ellis.waters@considine.com",
////    "kling.antonio@gmail.com",
////    "ressie.kuhlman@yahoo.com",
////    "unolan@bogan.com",
////    "trycia77@gmail.com",
////    "braulio.osinski@mayer.org",
////    "tara86@yahoo.com",
////    "kprosacco@rosenbaum.com",
////    "jstamm@gmail.com",
////    "dietrich.maximillia@yahoo.com",
////    "ffadel@price.com",
////    "lilyan.mitchell@goldner.biz",
////    "boris.rempel@yahoo.com",
////    "muller.dorothea@rutherford.com",
////    "anastasia67@veum.com",
////    "haylee.wuckert@hotmail.com",
////    "morissette.destini@shields.com",
////    "nellie.white@yahoo.com",
////    "saltenwerth@nicolas.com",
////    "sylvester.windler@gmail.com",
////    "deven.funk@yahoo.com",
////    "marks.maritza@gmail.com",
////    "morissette.maybelle@fahey.com",
////    "zreinger@harvey.com",
////    "lakin.oswald@nienow.info",
////    "isabell.boyer@yahoo.com",
////    "little.newton@greenfelder.com",
////    "osborne68@beier.net",
////    "layne.buckridge@wunsch.com",
////    "ratke.abe@yahoo.com",
////    "juliet33@hotmail.com",
////    "louisa78@gmail.com",
////    "schmidt.tiana@gmail.com",
////    "lemke.camryn@keebler.com",
////    "mauer@schiller.biz",
////    "qmayert@bashirian.com",
////    "jameson85@zboncak.info",
////    "gerald.oreilly@bahringer.info",
////    "julianne58@roberts.com",
////    "brayan30@nikolaus.com",
////    "vdaniel@yahoo.com",
////    "fharris@friesen.info",
////    "morton94@hammes.com",
////    "hattie94@yahoo.com",
////    "bchristiansen@beier.com",
////    "kassandra15@yahoo.com",
////    "coberbrunner@hotmail.com",
////    "domenic07@ebert.com",
////    "jgrady@turcotte.info",
////    "marguerite.klein@johnson.biz",
////    "mccullough.dalton@hotmail.com",
////    "rice.alek@dach.com",
////    "vilma00@hotmail.com",
////    "avis50@yahoo.com",
////    "gillian.mayer@gmail.com",
////    "njast@mayert.com",
////    "moore.payton@herman.com",
////    "ejones@waelchi.com",
////    "georgette35@gmail.com",
////    "mvon@hotmail.com",
////    "ziemann.bertha@kuhn.com",
////    "selmer16@swift.biz",
////    "heloise64@gmail.com",
////    "zachary91@gmail.com",
////    "elenor.lynch@nikolaus.com",
////    "lind.mabel@treutel.com",
////    "fhowe@osinski.com",
////    "schaefer.tad@hotmail.com",
////    "cesar44@wolf.com",
////    "haag.philip@gmail.com",
////    "ritchie.jimmy@ward.org",
////    "squitzon@hotmail.com",
////    "tyra38@yahoo.com",
////    "prohaska.marianna@yahoo.com",
////    "damien29@hotmail.com",
////    "whayes@gmail.com",
////    "hillard.grimes@gmail.com",
////    "nschmidt@steuber.com",
////    "wintheiser.shirley@reinger.info",
////    "leuschke.wava@yahoo.com",
////    "eleanora36@kemmer.com",
////    "shettinger@yahoo.com",
////    "botsford.chance@hotmail.com",
////    "terrell.davis@gmail.com",
////    "rosenbaum.hailey@mcclure.biz",
////    "stiedemann.antonina@feest.com",
////    "lelah78@hotmail.com",
////    "grant.martina@yahoo.com",
////    "lolita.casper@hotmail.com",
////    "liana.pfannerstill@towne.com",
////    "seamus77@gmail.com",
////    "shania.krajcik@grady.biz",
////    "dayton23@gmail.com",
////    "heidenreich.abbie@gmail.com",
////    "leuschke.dimitri@schuppe.net",
////    "joaquin.schulist@yahoo.com",
////    "cale.botsford@nikolaus.com",
////    "lolita.abshire@fay.com",
////    "champlin.celestine@yahoo.com",
////    "lmorar@kihn.com",
////    "bechtelar.rossie@yahoo.com",
////    "xjaskolski@yahoo.com",
////    "gina.quitzon@yahoo.com",
////    "gaylord78@bruen.com",
////    "alexandrea.smith@yahoo.com",
////    "rolfson.frida@schmitt.com",
////    "qpouros@yahoo.com",
////    "casey24@schoen.biz",
////    "milton.goyette@white.com",
////    "spinka.layne@mosciski.com",
////    "dell80@ward.com",
////    "lea.lang@yahoo.com",
////    "jamar.huel@powlowski.org",
////    "oschmeler@marquardt.org",
////    "kathleen.quitzon@rodriguez.com",
////    "beer.easter@mertz.com",
////    "alfonzo.beahan@hotmail.com",
////    "brown.kade@hahn.com",
////    "wunsch.constantin@oberbrunner.net",
////    "mertz.cristobal@harris.biz",
////    "leanne47@grady.com",
////    "kelsi.hamill@oreilly.biz",
////    "emie.ankunding@gmail.com",
////    "marvin.shanna@gmail.com",
////    "gibson.sincere@hotmail.com",
////    "uriah.koss@yahoo.com",
////    "benny76@hotmail.com",
////    "dakota49@yahoo.com",
////    "jairo04@hotmail.com",
////    "sschiller@hotmail.com",
////    "pat83@hotmail.com",
////    "blanda.eli@yahoo.com",
////    "stark.shanny@willms.com",
////    "nya.denesik@yahoo.com",
////    "kraig98@buckridge.com",
////    "ptorp@yahoo.com",
////    "narciso.reilly@emard.net",
////    "dell33@gmail.com",
////    "zane11@lowe.com",
////    "effertz.kellen@skiles.org",
////    "jamal.hackett@hill.com",
////    "bartell.adalberto@roob.org",
////    "sam49@gmail.com",
////    "ottis05@dietrich.biz",
////    "rbraun@ernser.com",
////    "luis.lockman@yahoo.com",
////    "ken56@leffler.biz",
////    "bayer.arlene@glover.com",
////    "tanner03@yahoo.com",
////    "kbatz@schultz.biz",
////    "crist.emmett@legros.net",
////    "ajones@ziemann.biz",
////    "brant.adams@gmail.com",
////    "janae.gibson@gmail.com",
////    "alvera70@hotmail.com",
////    "skub@yahoo.com",
////    "dorothea46@johnson.info",
////    "mueller.kiera@gmail.com",
////    "lang.damon@wiegand.info",
////    "gskiles@greenholt.com",
////    "ondricka.darren@johnston.net",
////    "renee35@yahoo.com",
////    "lonny28@klein.biz",
////    "ibaumbach@yahoo.com",
////    "dario50@hotmail.com",
////    "qraynor@hotmail.com",
////    "jeremy78@hotmail.com",
////    "plittle@hotmail.com",
////    "kaylee15@hotmail.com",
////    "dwalter@fisher.org",
////    "silas05@cremin.biz",
////    "mohr.kaycee@gmail.com",
////    "welch.brittany@hotmail.com",
////    "bernita.thiel@kovacek.com",
////    "doyle.lew@tillman.com",
////    "mmills@corkery.biz",
////    "fhermann@pfannerstill.com",
////    "geovany51@hotmail.com",
////    "austen78@quitzon.com",
////    "matilda98@stamm.com",
////    "rosenbaum.deron@gmail.com",
////    "btremblay@hotmail.com",
////    "lottie.shanahan@hotmail.com",
////    "zgoldner@yahoo.com",
////    "maximus.herzog@emmerich.com",
////    "donnelly.jeff@rolfson.com",
////    "rhartmann@gmail.com",
////    "anderson.joy@hotmail.com",
////    "mccullough.wilford@carter.com",
////    "clementina78@wehner.com",
////    "jratke@yahoo.com",
////    "milton.koss@barrows.biz",
////    "welch.elfrieda@hotmail.com",
////    "adell.wolf@hotmail.com",
////    "vergie34@waelchi.net",
////    "ltowne@kulas.com",
////    "ella98@torp.biz",
////    "jlarson@gmail.com",
////    "bobby56@hotmail.com",
////    "thompson.jarvis@gmail.com",
////    "pullrich@gislason.com",
////    "bashirian.anderson@yahoo.com",
////    "rusty14@yahoo.com",
////    "mazie04@gmail.com",
////    "felipe81@hotmail.com",
////    "jbeahan@yahoo.com",
////    "yhagenes@hotmail.com",
////    "russel.danielle@gmail.com",
////    "hfisher@bartell.com",
////    "bashirian.stacy@hotmail.com",
////    "cassin.maryjane@hotmail.com",
////    "paucek.philip@gmail.com",
//
//
//];

//$compaore = array_diff($newarray, $names);
//
//foreach($compaore as $no){
//
//    echo "\"$no\"" . ",\r\n";
//}
//print_r( $compaore);
////
//foreach($newarray as $name){
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



