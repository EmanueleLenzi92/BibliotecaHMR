<!DOCTYPE html><html lang="it"><head><meta charset="UTF-8">


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111997111-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-111997111-1');
</script>

<title>Linee guida - Biblioteca</title>

<link rel="stylesheet" type="text/css" href="../HMR_Style.css">

<link 
	href="https://fonts.googleapis.com/css?family=Source+Sans+Pro"
	rel="stylesheet">

<link rel="icon" type="image/png" 
	href="../Assets/Images/HMR_2017g_GC-WebFavIcon16x16.png" />

<script 
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js">
</script> 

<script
	src='../EPICAC/JSwebsite/searchAndSharing.js'>
</script>

<script
	src='../Assets/JS/HMR_CreaHTML.js'>
</script>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<meta name="description" content="" />

<meta name="keywords" content="" />

	<!--Collection-->
	<?php  
	require ('../../Config/Biblio_config.php');
	require ('../Biblio/Assets/PHP/functions_get.php');
	include('../Administration/Assets/PHP/sessionSet.php');

	?>
	<script  src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
	<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type='text/javascript' src='Assets/JS/format_print_biblio2.0.js'></script>
	<script type='text/javascript' src='Assets/JS/collections.js'></script>
	<!--Collection-->

	<?php
	// get id items of that collection 
	if(isset($_SESSION['fileSecretPermission'])){$fileSecretPermission = $_SESSION['fileSecretPermission'];} else {$fileSecretPermission= null;}
	$itemsOfCollection= get_collection_by_idCollection($conn, 133 , 1 ,$fileSecretPermission);
	?>
	<script>
	$(document).ready(function(){
	var collection= format_collection(<?php echo json_encode($itemsOfCollection); ?>)
	$("#result").append(collection)
	})
	</script>
	
			<?php
				
				// function for scrolling page at clicked link
				if(isset($_GET['id'])){
					
					echo "<script>
					$(document).ready(function(){ 
						
						//add class highlightedClickedLink to clicked link
						$('#".$_GET['id']."').addClass('highlightedClickedLink')
						
						//scroll to post
						
						$('html, body').animate({
							scrollTop: $('#".$_GET['id']."').offset().top
						}, );
						
						// hide class for clicked link
						$( '#".$_GET['id']."' ).switchClass( 'highlightedClickedLink', '', 2500 );
						
					});
					</script>";
				}
			?>

<style>

.img-with-text {
    text-align: justify;
    width: [width of img];
}

.img-with-text img {
    display: block;
    margin: 0 auto;
}
</style>

</head>

<body>

<!-- Standard HMRWeb header ///////////////////////////////////////////////////
// For banner:
// - set level, 1 = "../", 2 = "../../" and so on;
// - set image, file name and extension, no path, has to be in /Assets/Images.
// For menu:
// - set level, same as banner;
// - set active menu entry, 1=Cronologia, 2=Eventi and so on.  -->

<div class="HMR_Banner">
	<script>
		creaHeader(3, "HMR_2017g_GC-WebHeaderRite-270x105-1.png")
	</script> 
</div>
<div id="HMR_Menu" class="HMR_Menu">
	<script>
		creaMenu(3, 8)
	</script> 
</div>

<div class="HMR_Content"><div class= "HMR_Text">

<!-- Actual page content starts here ///////////////////////////////////////-->

<h1>Biblioteca</h1>

<p>Fin dalla sua nascita, HMR ha prodotto e raccolto un ingente numero di documenti, fruibili
liberamente all’interno del sito web. Il materiale è diviso in:</p>

<ul>
<li>prodotti originali;</li>
<li>documenti di archivio, raccolti e resi disponibili in forma digitale;</li>
<li>altro materiale esistente, come per esempio articoli, non facilmente reperibili in rete.</li>
</ul>

<p>La documentazione più corposa di HMR è costituita dai documenti di archivio e da altri materiali digitalizzati; 
HMR produce infatti una gran quantità di scansioni digitali. Così come accade per altre istituzioni — come Google Patents,
che scannerizza i brevetti posseduti fisicamente dall'European Patent Office, o Internet Archive che digitalizza i testi —, 
HMR ha la responsabilità di effettuare una scansione digitale a partire da un documento fisico esistente.
</p>

<p>Il materiale di HMR è messo a disposizione dell’intera comunità degli interessati all'argomento, costituita da utenti 
generici, da chi collabora direttamente al progetto e dagli studenti.</p>

<p>Non tutte le risorse però sono pubbliche; ne costituiscono un esempio quei documenti privati che come
copie digitali non possono essere condivisi pubblicamente perché coperte da copyright, ma che
come record bibliografici sono informazioni utili che HMR si propone di condividere con la
comunità di ricerca in storia dell'informatica e con tutti gli interessati.</p>

<p>La Biblioteca digitale di HMR ha quindi lo scopo di (1) mettere in evidenza la responsabilità e il merito di chi ha 
operato una scansione digitale di un’opera; (2) mettere a disposizione di tutti gli utenti la citazione bibliografica 
dell’opera richiesta; (3) permettere a tutti gli utenti l’accesso alle risorse pubbliche e solo a chi ne detiene i permessi
quello alle risorse private.</p>

<p>Il modello di riferimento è basato sul modello concettuale FRBR (Functional Requirements for Bibliographic Records), ampliato per porre in evidenza il passaggio da un 
documento fisico alla manifestazione della scansione digitale.</p>

<h2 id="frbr">FRBR</h2>

<p>Il modello FRBR si propone di individuare i requisiti essenziali di un record bibliografico. Rappresenta il
 passaggio che intercorre dall'ideazione di un'opera fino alla sua realizzazione concreta. Prevede quattro entità,
 definite come:</p>
 
<ul>
<li>opera: creazione intellettuale o artistica rappresentata da un testo, una musica o un’altra forma di espressione — per esempio un film o un balletto — o da un oggetto materiale o un manufatto;</li>
<li>espressione: versioni o modificazioni riguardanti la forma, che non danno origine a un’opera nuova;</li>
<li>manifestazione: pubblicazione, cioè ogni documento destinato all’uso pubblico e fruibile mediante la lettura, l’ascolto, la visione o il tatto, prodotto o riprodotto in più esemplari con qualsiasi procedimento tecnico e su qualsiasi supporto;</li>
<li>esemplare: il singolo oggetto materiale (copia) prodotto e posto in circolazione come supporto di una pubblicazione.</li>
</ul>

<div style='text-align: center;'>
<img src='Assets/Img/frbr.png' width='50%' style='margin: 18px'>

</div>

<h2>FRBR(H)</h2>
<p>FRBR(H) è il modello ampliato su cui si basa la Biblioteca di HMR per mettere in evidenza il passaggio da uno specifico
esemplare fisico alla sua manifestazione della scansione digitale.</p>

<p>I due esempi successivi riguradanti l'opera <i>Architecture for a universal serial bus-based PC flash disk</i> mostrano la differenza tra FRBR e FRBR(H):</p>

<div id="frbr" style="text-align: center;">

    <img src='Assets/Img/frbrEsempi.png' width='90%' style='margin: 18px'>

</div> 


<p>Secondo il modello FRBR originale, dall’opera si passa all’espressione che, in questo caso è un brevetto. L’espressione 
ha due diverse manifestazioni: una cartacea, cioè il brevetto fisico 6148354A originale la cui copia fisica è conservata 
all’US Patent Office, e una digitale, scansionata e messa a disposizione da Google Patents. Il modello FRBR originale tratta quindi le scansioni come manifestazioni digitali derivanti da
un'espressione.</p>

<p>In questa rappresentazione si perde però l’informazione che
l’origine della manifestazione digitale è una copia fisica conservata all’Ufficio Brevetti, scansionata
 e condivisa sul web da Google Patents.</p>

<p>La rappresentazione estesa del nuovo modello FRBR(H) è un grafo in cui la manifestazione digitale non ha origine 
dall’espressione, ma dall’esemplare. In questo caso, dal livello dell’esemplare fisico conservato al Patent Office, si 
“torna” al livello della manifestazione che, per mezzo della scansione, diventa una ripubblicazione digitale.</p>

<h2 id="lineeguida">Linee guida per il catalogatore</h2>
<p>Il catalogatore cataloga un riferimento bibliografico seguendo il modello FRBR(H), inserendo in Biblioteca i dati riguardanti l'opera, l'espressione, la manifestazione e l'esemplare. Terminata la catalogazione, la Biblioteca automatizzerà la citazione secondo il tipo di manifestazione scelto.</p>
<p><b>NB: </b> prima di inserire una nuova opera, una nuova persona o una nuova istituzione, è buona norma accertarsi che non siano già presenti in Bibliotca facendo una ricerca nell'apposita <a href="index.php">pagina</a> per titolo o per autore/istituzione (spuntando la checkbox "avanzate"), o consultanto la pagina di inserimento di nuove persone e istituzioni accessibile dal menù di catalogazione. </p>

<h3>Opera</h3>
<p>A livello di opera il catalogatore può inserire persone o istituzioni con le loro responsabilità relative all'opera (e.g. autore, verbalizzante ecc.). Le persone o le istituzioni che hanno come responsabilità "autore", 
vengono sempre visualizzati per primi nella citazione bibliografica automatica. Se non ci sono responsabilità a livello di opera, non si inserisce nè alcuna persona nè alcuna istituzione.</p>
<p>Il titolo dell'opera è obbligatorio. Corrisponde al titolo principale del riferimento che si sta catalogando in lingua originale.</p>

<h3>Espressione</h3>

<p>A livello di espressione il catalogatore può inserire persone o istituzioni con le loro responsabilità relative all'espressione (e.g. curatore). Le persone o le istituzioni che hanno come responsabilità "autore (espressione)",
vengono sempre visualizzati per primi nella citazione bibliografica automatica e sovrascrivono eventuali autori inseriti a livello di opera.
Le persone o le istituzioni che hanno come responsabilità "curatore degli atti", vengono sempre visualizzati nella citazione bibliografica automatica dopo gli atti se il riferimento che si sta catalogando è una pubblicazione in atti di congresso.
Le persone o le istituzioni che hanno come responsabilità "curatore", vengono sempre visualizzati nella citazione bibliografica automatica dopo gli autori se il riferimento che si sta catalogando non è una pubblicazione in atti di congresso.
Se non ci sono responsabilità a livello di espressione, non si inserisce nè alcuna persona nè alcuna istituzione.
</p>

<p>Tramite gli input di filtraggio, l'espressione va collegata alla sua opera.</p>

<p>Il titolo dell'espressione si inserisce solo se il riferimento che si sta catalogando è una traduzione. Allora si inserisce il titolo tradotto. Altrimenti, il campo non va compilato.</p> 

<p>Il tipo dell'espressione è obbligatorio, e corrisponde alla forma grafica del riferimento che si sta catalogando (e.g. un articolo o un saggio).</p>

<h3>Casi particolari sui tipi di espressione</h3>

<p>Si inserisce come tipo "articolo" quando il riferimento che si sta catalogando è un articolo scientifico destinato a una conferenza o a una rivista scientifica; si inserisce "saggio" quando è un libro o una monografia.</p>

<h3>Manifestazione</h3>

<p>A livello di manifestazione il catalogatore può inserire persone o istituzioni con le loro responsabilità relative alla manifestazione (e.g. editore).
Le istituzioni che hanno come responsabilità "editore",
vengono sempre visualizzati in fondo alla citazione bibliografica automatica.
Le istituzioni che hanno come responsabilità "editore degli atti", vengono sempre visualizzati nella citazione bibliografica automatica dopo gli atti se il riferimento che si sta catalogando è una pubblicazione in atti di congresso.
Le persone che hanno come responsabilità "relatore" e le istituzioni che hanno come responsabilità "Ospitato da", vengono sempre visualizzati nella citazione bibliografica se il riferimento che si sta catalogando è una Tesi.
Se non ci sono responsabilità a livello di manifestazione, non si inserisce nè alcuna persona nè alcuna istituzione.
</p>

<p>Tramite gli input di filtraggio, la manifestazione va collegata alla sua espressione o al suo esemplare. Se il riferimento che si sta catalogando è una scansione, va collegato al suo esemplare da cui deriva, specificando a livello della manifestazione della scansione, la responsabilità di chi ha scansionato quel documento.</p>

<p>Il tipo della manifestazione è obbligatorio, e corrisponde al tipo di pubblicazione in cui si manifesta il riferimento che si sta catalogando (e.g. libro o pubblicazione in atti di congresso).
In base al tipo di manifestazione scelto, cambiano i campi da riempire.</p>

<h3>Casi particolari sui tipi di manifestazione</h3>

<p>la maggior parte dei manuali, specialmente quando sono editi dalla stessa casa che produce l'oggetto, sono di tipo "rapporto tecnico"; quando invece sono editi da altri e sono sostanzialmente indipendenti, sono di tipo "libro".</p>

<h3>Esemplare</h3>

<p>A livello di esemplare il catalogatore può inserire persone o istituzioni con le loro responsabilità relative all'esemplare (e.g. conservazione pubblica o privata).
</p>

<p>Tramite gli input di filtraggio, l'esemplare va collegato alla sua manifestazione.</p>

<p>Si può caricare sul server il file locale del documento che si sta catalogando, specificando la riservatezza:</p>
<ul>
<li>livello 1: pubblico;</li>
<li>livello 2: riservatezza media (solo gli utenti registrati);</li>
<li>livello 3: riservatezza massima (solo alcuni utenti con permesso specifico).</li>
</ul>
<p>Se si è incerti sul tipo di riservatezza, mettere sempre il livello 3.</p>
<p>In alternativa, si può inserire un link esterno al documento che si sta catalogando, specificando la data di ultima visita.</p>


<div id="result"></div>
 

<br/><br/>

<!-- Actual page content ends here /////////////////////////////////////////-->

</div></div>


<!-- Standard HMRWeb footer////////////////////////////////////////////////////
// Set:
// - level, 1 = "../", 2 = "../../" and so on;
// - set copyright start year, YYYY
// - set copyright end year, YYYY;
// - set copyright owner, default "Progetto HMR";
// - set date of page creation, YYYY/MM/DD.  -->

<div class="HMR_Footer">
	<script>
		creaFooter(1, "2020", "2021", "E. Lenzi", 
                                     "2021/01/20", "2021/05/11 18:15")
	</script> 
</div>

</body>

</html>