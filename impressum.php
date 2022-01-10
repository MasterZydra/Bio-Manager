<?php
/*
* impressum.php
* -------------
* Impressum and DSGVO
*
* @Author: David Hein
*/
include 'Modules/header_everyone.php';
include 'Modules/PermissionCheck.php';
include 'Modules/header.php';

// Check if file exists to prevent warnings
if (file_exists('config/ImpressumConfig.php')) {
    include 'config/ImpressumConfig.php';
}
?>

<h1>Impressum</h1>
<p>
    <?php echo $impressum['provider_name'] ??= 'PLATZHALTER'; ?><br>
    <?php echo $impressum['provider_street'] ??= 'PLATZHALTER'; ?><br>
    <?php
        echo $impressum['provider_postalCode'] ??= 'PLATZHALTER';
        echo ' ';
        echo $impressum['provider_city'] ??= 'PLATZHALTER';
    ?><br>
    E-Mail: <a href="mailto:<?php echo $impressum['provider_email'] ??= 'PLATZHALTER'; ?>">
        <?php echo $impressum['provider_email'] ??= 'PLATZHALTER'; ?></a>
</p>
<p>
    <strong>Verantwortlich für den Inhalt (gem. § 55 Abs. 2 RStV):</strong><br>
    <?php echo $impressum['responsible_name'] ??= 'PLATZHALTER'; ?><br>
    <?php echo $impressum['responsible_street'] ??= 'PLATZHALTER'; ?><br>
    <?php
        echo $impressum['responsible_postalCode'] ??= 'PLATZHALTER';
        echo ' ';
        echo $impressum['responsible_city'] ??= 'PLATZHALTER';
    ?><br>
    E-Mail: <a href="mailto:<?php echo $impressum['responsible_email'] ??= 'PLATZHALTER'; ?>">
        <?php echo $impressum['responsible_email'] ??= 'PLATZHALTER'; ?></a>
</p>
<p>
    <strong>Disclaimer – rechtliche Hinweise</strong><br>
    § 1 Warnhinweis zu Inhalten<br>
    Die kostenlosen und frei zugänglichen Inhalte dieser Webseite wurden mit größtmöglicher Sorgfalt erstellt. 
    Der Anbieter dieser Webseite übernimmt jedoch keine Gewähr für die Richtigkeit und Aktualität der bereitgestellten 
    kostenlosen und frei zugänglichen journalistischen Ratgeber und Nachrichten. Namentlich gekennzeichnete Beiträge 
    geben die Meinung des jeweiligen Autors und nicht immer die Meinung des Anbieters wieder. Allein durch den Aufruf 
    der kostenlosen und frei zugänglichen Inhalte kommt keinerlei Vertragsverhältnis zwischen dem Nutzer und dem 
    Anbieter zustande, insoweit fehlt es am Rechtsbindungswillen des Anbieters.
</p>
<p>
    § 2 Externe Links<br>
    Diese Website enthält Verknüpfungen zu Websites Dritter ("externe Links"). Diese Websites unterliegen der Haftung 
    der jeweiligen Betreiber. Der Anbieter hat bei der erstmaligen Verknüpfung der externen Links die fremden Inhalte 
    daraufhin überprüft, ob etwaige Rechtsverstöße bestehen. Zu dem Zeitpunkt waren keine Rechtsverstöße ersichtlich. 
    Der Anbieter hat keinerlei Einfluss auf die aktuelle und zukünftige Gestaltung und auf die Inhalte der verknüpften 
    Seiten. Das Setzen von externen Links bedeutet nicht, dass sich der Anbieter die hinter dem Verweis oder Link 
    liegenden Inhalte zu Eigen macht. Eine ständige Kontrolle der externen Links ist für den Anbieter ohne konkrete 
    Hinweise auf Rechtsverstöße nicht zumutbar. Bei Kenntnis von Rechtsverstößen werden jedoch derartige externe Links 
    unverzüglich gelöscht.
</p>
<p>
    § 3 Urheber- und Leistungsschutzrechte<br>
    Die auf dieser Website veröffentlichten Inhalte unterliegen dem deutschen Urheber- und Leistungsschutzrecht. Jede 
    vom deutschen Urheber- und Leistungsschutzrecht nicht zugelassene Verwertung bedarf der vorherigen schriftlichen 
    Zustimmung des Anbieters oder jeweiligen Rechteinhabers. Dies gilt insbesondere für Vervielfältigung, Bearbeitung, 
    Übersetzung, Einspeicherung, Verarbeitung bzw. Wiedergabe von Inhalten in Datenbanken oder anderen elektronischen 
    Medien und Systemen. Inhalte und Rechte Dritter sind dabei als solche gekennzeichnet. Die unerlaubte 
    Vervielfältigung oder Weitergabe einzelner Inhalte oder kompletter Seiten ist nicht gestattet und strafbar. 
    Lediglich die Herstellung von Kopien und Downloads für den persönlichen, privaten und nicht kommerziellen Gebrauch 
    ist erlaubt.
</p>
<p>
    Die Darstellung dieser Website in fremden Frames ist nur mit schriftlicher Erlaubnis zulässig.
</p>
<p>
    § 4 Besondere Nutzungsbedingungen<br>
    Soweit besondere Bedingungen für einzelne Nutzungen dieser Website von den vorgenannten Paragraphen abweichen, wird 
    an entsprechender Stelle ausdrücklich darauf hingewiesen. In diesem Falle gelten im jeweiligen Einzelfall die 
    besonderen Nutzungsbedingungen.
</p>
<p>
    Quelle: <a href="https://www.juraforum.de/impressum-generator/">Impressum Vorlage von JuraForum.de</a>
</p>
<h1>Datenschutz</h1>
<p>
    Wir informieren Sie nachfolgend gemäß den gesetzlichen Vorgaben des Datenschutzrechts (insb. gemäß BDSG n.F. und 
    der europäischen Datenschutz-Grundverordnung ‚DS-GVO‘) über die Art, den Umfang und Zweck der Verarbeitung 
    personenbezogener Daten durch unser Unternehmen. Diese Datenschutzerklärung gilt auch für unsere Websites und 
    Sozial-Media-Profile. Bezüglich der Definition von Begriffen wie etwa „personenbezogene Daten“ oder „Verarbeitung“ 
    verweisen wir auf Art. 4 DS-GVO.
</p>
<p>
    <strong>Name und Kontaktdaten des / der Verantwortlichen</strong><br>
    Unser/e Verantwortliche/r (nachfolgend „Verantwortlicher“) i.S.d. Art. 4 Zif. 7 DS-GVO ist:
</p>
<p>
    <?php echo $impressum['responsible_name'] ??= 'PLATZHALTER'; ?><br>
    <?php echo $impressum['responsible_street'] ??= 'PLATZHALTER'; ?><br>
    <?php
        echo $impressum['responsible_postalCode'] ??= 'PLATZHALTER';
        echo ' ';
        echo $impressum['responsible_city'] ??= 'PLATZHALTER';
    ?><br>
    E-Mail: <a href="mailto:<?php echo $impressum['responsible_email'] ??= 'PLATZHALTER'; ?>">
        <?php echo $impressum['responsible_email'] ??= 'PLATZHALTER'; ?></a>
</p>
<p>
    <strong>Datenarten, Zwecke der Verarbeitung und Kategorien betroffener Personen</strong><br>
    Nachfolgend informieren wir Sie über Art, Umfang und Zweck der Erhebung, Verarbeitung und Nutzung personenbezogener 
    Daten.
</p>
<p><strong>1. Arten der Daten, die wir verarbeiten</strong><br>
    Nutzungsdaten (Zugriffszeiten, besuchte Websites etc.), Kommunikationsdaten (IP-Adresse etc.),
</p>
<p>
    <strong>2. Zwecke der Verarbeitung nach Art. 13 Abs. 1 c) DS-GVO</strong><br>
    Website technisch und wirtschaftlich optimieren, Optimierung und statistische Auswertung unserer Dienste, 
    Nutzererfahrung verbessern, Website benutzerfreundlich gestalten, Erstellung von Statistiken,
</p>
<p>
    <strong>3. Kategorien der betroffenen Personen nach Art. 13 Abs. 1 e) DS-GVO</strong><br>
    Besucher/Nutzer der Website,
</p>
<p>
    Die betroffenen Personen werden zusammenfassend als „Nutzer“ bezeichnet.
</p>
<p>
    <strong>Rechtsgrundlagen der Verarbeitung personenbezogener Daten</strong><br>
    Nachfolgend Informieren wir Sie über die Rechtsgrundlagen der Verarbeitung personenbezogener Daten:
</p>
<ol>
    <li>Wenn wir Ihre Einwilligung für die Verarbeitung personenbezogenen Daten eingeholt haben, ist Art. 6 Abs. 1 S. 1 
        lit. a) DS-GVO Rechtsgrundlage.</li>
    <li>Ist die Verarbeitung zur Erfüllung eines Vertrags oder zur Durchführung vorvertraglicher Maßnahmen
        erforderlich, die auf Ihre Anfrage hin erfolgen, so ist Art. 6 Abs. 1 S. 1 lit. b) DS-GVO Rechtsgrundlage.</li>
    <li>Ist die Verarbeitung zur Erfüllung einer rechtlichen Verpflichtung erforderlich, der wir unterliegen (z.B. 
        gesetzliche Aufbewahrungspflichten), so ist Art. 6 Abs. 1 S. 1 lit. c) DS-GVO Rechtsgrundlage.</li>
    <li>Ist die Verarbeitung erforderlich, um lebenswichtige Interessen der betroffenen Person oder einer anderen 
        natürlichen Person zu schützen, so ist Art. 6 Abs. 1 S. 1 lit. d) DS-GVO Rechtsgrundlage.</li>
    <li>Ist die Verarbeitung zur Wahrung unserer oder der berechtigten Interessen eines Dritten erforderlich und 
        überwiegen diesbezüglich Ihre Interessen oder Grundrechte und Grundfreiheiten nicht, so ist Art. 6 Abs. 1 S. 1 
        lit. f) DS-GVO Rechtsgrundlage.</li>
</ol>
<p>
    <strong>Weitergabe personenbezogener Daten an Dritte und Auftragsverarbeiter</strong><br>
    Ohne Ihre Einwilligung geben wir grundsätzlich keine Daten an Dritte weiter. Sollte dies doch der Fall sein, dann 
    erfolgt die Weitergabe auf der Grundlage der zuvor genannten Rechtsgrundlagen z.B. bei der Weitergabe von Daten an 
    Online-Paymentanbieter zur Vertragserfüllung oder aufgrund gerichtlicher Anordnung oder wegen einer gesetzlichen 
    Verpflichtung zur Herausgabe der Daten zum Zwecke der Strafverfolgung, zur Gefahrenabwehr oder zur Durchsetzung der 
    Rechte am geistigen Eigentum.<br>
    Wir setzen zudem Auftragsverarbeiter (externe Dienstleister z.B. zum Webhosting unserer Websites und Datenbanken) 
    zur Verarbeitung Ihrer Daten ein. Wenn im Rahmen einer Vereinbarung zur Auftragsverarbeitung an die 
    Auftragsverarbeiter Daten weitergegeben werden, erfolgt dies immer nach Art. 28 DS-GVO. Wir wählen dabei unsere 
    Auftragsverarbeiter sorgfältig aus, kontrollieren diese regelmäßig und haben uns ein Weisungsrecht hinsichtlich der 
    Daten einräumen lassen. Zudem müssen die Auftragsverarbeiter geeignete technische und organisatorische Maßnahmen 
    getroffen haben und die Datenschutzvorschriften gem. BDSG n.F. und DS-GVO einhalten
</p>
<p>
    <strong>Datenübermittlung in Drittstaaten</strong><br>
    Durch die Verabschiedung der europäischen Datenschutz-Grundverordnung (DS-GVO) wurde eine einheitliche Grundlage 
    für den Datenschutz in Europa geschaffen. Ihre Daten werden daher vorwiegend durch Unternehmen verarbeitet, für die 
    DS-GVO Anwendung findet. Sollte doch die Verarbeitung durch Dienste Dritter außerhalb der Europäischen Union oder 
    des Europäischen Wirtschaftsraums stattfinden, so müssen diese die besonderen Voraussetzungen der Art. 44 ff. 
    DS-GVO erfüllen. Das bedeutet, die Verarbeitung erfolgt aufgrund besonderer Garantien, wie etwa die von der 
    EU-Kommission offiziell anerkannte Feststellung eines der EU entsprechenden Datenschutzniveaus oder der Beachtung 
    offiziell anerkannter spezieller vertraglicher Verpflichtungen, der so genannten „Standardvertragsklauseln“. Bei 
    US-Unternehmen erfüllt die Unterwerfung unter das sog. „Privacy-Shield“, dem Datenschutzabkommen zwischen der EU 
    und den USA, diese Voraussetzungen.
</p>
<p>
    <strong>Löschung von Daten und Speicherdauer</strong><br>
    Sofern nicht in dieser Datenschutzerklärung ausdrücklich angegeben, werden Ihre personenbezogen Daten gelöscht oder 
    gesperrt, sobald der Zweck für die Speicherung entfällt, es sei denn deren weitere Aufbewahrung ist zu 
    Beweiszwecken erforderlich oder dem stehen gesetzliche Aufbewahrungspflichten entgegenstehen. Darunter fallen etwa 
    handelsrechtliche Aufbewahrungspflichten von Geschäftsbriefen nach § 257 Abs. 1 HGB (6 Jahre) sowie 
    steuerrechtliche Aufbewahrungspflichten nach § 147 Abs. 1 AO von Belegen (10 Jahre). Wenn die vorgeschriebene 
    Aufbewahrungsfrist abläuft, erfolgt eine Sperrung oder Löschung Ihrer Daten, es sei denn die Speicherung ist 
    weiterhin für einen Vertragsabschluss oder zur Vertragserfüllung erforderlich.
</p>
<p>
    <strong>Bestehen einer automatisierten Entscheidungsfindung</strong>.
    Wir setzen keine automatische Entscheidungsfindung oder ein Profiling ein.
</p>
<p>
    <strong>Bereitstellung unserer Website und Erstellung von Logfiles</strong>
</p>
<ol>
    <li>
        <p>Wenn Sie unsere Webseite lediglich informatorisch nutzen (also keine Registrierung und auch keine 
            anderweitige Übermittlung von Informationen), erheben wir nur die personenbezogenen Daten, die Ihr Browser 
            an unseren Server übermittelt.<br>
            Wenn Sie unsere Website betrachten möchten, erheben wir die folgenden Daten:
        </p>
        <ul>
            <li>IP-Adresse;</li>
            <li>Internet-Service-Provider des Nutzers;</li>
            <li>Datum und Uhrzeit des Abrufs;</li>
            <li>Browsertyp;</li>
            <li>Sprache und Browser-Version;</li>
            <li>Inhalt des Abrufs;</li>
            <li>Zeitzone;</li>
            <li>Zugriffsstatus/HTTP-Statuscode;</li>
            <li>Datenmenge;</li>
            <li>Websites, von denen die Anforderung kommt;</li>
            <li>
                Betriebssystem.<br><br>
                Eine Speicherung dieser Daten zusammen mit anderen personenbezogenen Daten von Ihnen findet nicht statt.
            </li>
        </ul>
    </li>
    <li>
        <p>
            Diese Daten dienen dem Zweck der nutzerfreundlichen, funktionsfähigen und sicheren Auslieferung unserer 
            Website an Sie mit Funktionen und Inhalten sowie deren Optimierung und statistischen Auswertung.
        </p>
    </li>
    <li>
        <p>
            Rechtsgrundlage hierfür ist unser in den obigen Zwecken auch liegendes berechtigtes Interesse an der 
            Datenverarbeitung nach Art. 6 Abs. 1 S.1 lit. f) DS-GVO.
        </p>
    </li>
    <li>Wir speichern aus Sicherheitsgründen diese Daten in Server-Logfiles für die Speicherdauer von Tagen. Nach 
        Ablauf dieser Frist werden diese automatisch gelöscht, es sei denn wir benötigen deren Aufbewahrung zu 
        Beweiszwecken bei Angriffen auf die Serverinfrastruktur oder anderen Rechtsverletzungen.</li>
</ol>
<p><strong>Cookies</strong></p>
<ol>
    <li>
        <p>Wir verwenden sog. Cookies bei Ihrem Besuch unserer Website. Cookies sind kleine Textdateien, die Ihr 
            Internet-Browser auf Ihrem Rechner ablegt und speichert. Wenn Sie unsere Website erneut aufrufen, geben 
            diese Cookies Informationen ab, um Sie automatisch wiederzuerkennen. Die so erlangten Informationen dienen 
            dem Zweck, unsere Webangebote technisch und wirtschaftlich zu optimieren und Ihnen einen leichteren und 
            sicheren Zugang auf unsere Website zu ermöglichen. Wir informieren Sie dazu beim Aufruf unserer Website 
            mittels eines Hinweises auf unsere Datenschutzerklärung über die Verwendung von Cookies zu den zuvor 
            genannten Zwecken und wie Sie dieser widersprechen bzw. deren Speicherung verhindern können („Opt-out“). 
            Unsere Website nutzt Session-Cookies, persistente Cookies und Cookies von Drittanbietern:</p>
        <ul>
            <li><strong>Session-Cookies:</strong> Wir verwenden sog. Cookies zum Wiedererkennen mehrfacher Nutzung 
            eines Angebots durch denselben Nutzer (z.B. wenn Sie sich eingeloggt haben zur Feststellung Ihres 
            Login-Status). Wenn Sie unsere Seite erneut aufrufen, geben diese Cookies Informationen ab, um Sie 
            automatisch wiederzuerkennen. Die so erlangten Informationen dienen dazu, unsere Angebote zu optimieren und 
            Ihnen einen leichteren Zugang auf unsere Seite zu ermöglichen. Wenn Sie den Browser schließen oder Sie sich 
            ausloggen, werden die Session-Cookies gelöscht.</li>
            <li><strong>Persistente Cookies:</strong> Diese werden automatisiert nach einer vorgegebenen Dauer
            gelöscht, die sich je nach Cookie unterscheiden kann. In den Sicherheitseinstellungen Ihres Browsers können 
            Sie die Cookies jederzeit löschen.</li>
            <li><strong>Cookies von Drittanbietern (Third-Party-Cookies):</strong> Entsprechend Ihren Wünschen können 
            Sie können Ihre Browser-Einstellung konfigurieren und z. B. Die Annahme von Third-Party-Cookies oder allen 
            Cookies ablehnen. Wir weisen Sie jedoch an dieser Stelle darauf hin, dass Sie dann eventuell nicht alle 
            Funktionen dieser Website nutzen können. Lesen Sie Näheres zu diesen Cookies bei den jeweiligen 
            Datenschutzerklärungen zu den Drittanbietern.</li>
        </ul>
    </li>
    <li>
        <p>Rechtsgrundlage dieser Verarbeitung ist Art. 6 Abs. 1 S. lit. b) DS-GVO, wenn die Cookies zur 
            Vertragsanbahnung z.B. bei Bestellungen gesetzt werden und ansonsten haben wir ein berechtigtes Interesse 
            an der effektiven Funktionalität der Website, so dass in dem Falle Art. 6 Abs. 1 S. 1 lit. f) DS-GVO 
            Rechtsgrundlage ist.</p>
    </li>
    <li><strong>Widerspruch und „Opt-Out“:</strong> Das Speichern von Cookies auf Ihrer Festplatte können Sie allgemein 
    verhindern, indem Sie in Ihren Browser-Einstellungen „keine Cookies akzeptieren“ wählen. Dies kann aber eine 
    Funktionseinschränkung unserer Angebote zur Folge haben. Sie können dem Einsatz von Cookies von Drittanbietern zu 
    Werbezwecken über ein sog. „Opt-out“ über diese amerikanische Website (<a href="https://optout.aboutads.info">
        https://optout.aboutads.info</a>) oder diese europäische Website (<a
        href="http://www.youronlinechoices.com/de/praferenzmanagement/">
        http://www.youronlinechoices.com/de/praferenzmanagement/</a>) widersprechen.</li>
</ol>
<p><strong>Kontaktaufnahme per Kontaktformular / E-Mail / Fax / Post</strong></p>
<ol>
    <li>
        <p>Bei der Kontaktaufnahme mit uns per Kontaktformular, Fax, Post oder E-Mail werden Ihre Angaben zum Zwecke 
            der Abwicklung der Kontaktanfrage verarbeitet.</p>
    </li>
    <li>
        <p>Rechtsgrundlage für die Verarbeitung der Daten ist bei Vorliegen einer Einwilligung von Ihnen Art. 6 Abs. 1 
            S. 1 lit. a) DS-GVO. Rechtsgrundlage für die Verarbeitung der Daten, die im Zuge einer Kontaktanfrage oder 
            E-Mail, eines Briefes oder Faxes übermittelt werden, ist Art. 6 Abs. 1 S. 1 lit. f) DS-GVO. Der 
            Verantwortliche hat ein berechtigtes Interesse an der Verarbeitung und Speicherung der Daten, um Anfragen 
            der Nutzer beantworten zu können, zur Beweissicherung aus Haftungsgründen und um ggf. seiner gesetzlichen 
            Aufbewahrungspflichten bei Geschäftsbriefen nachkommen zu können. Zielt der Kontakt auf den Abschluss eines 
            Vertrages ab, so ist zusätzliche Rechtsgrundlage für die Verarbeitung Art. 6 Abs. 1 S. 1 lit. b) DS-GVO.</p>
    </li>
    <li>
        <p>Wir können Ihre Angaben und Kontaktanfrage in unserem Customer-Relationship-Management System ("CRM System") 
            oder einem vergleichbaren System speichern.</p>
    </li>
    <li>
        <p>Die Daten werden gelöscht, sobald sie für die Erreichung des Zweckes ihrer Erhebung nicht mehr erforderlich 
            sind. Für die personenbezogenen Daten aus der Eingabemaske des Kontaktformulars und diejenigen, die per 
            E-Mail übersandt wurden, ist dies dann der Fall, wenn die jeweilige Konversation mit Ihnen beendet ist. 
            Beendet ist die Konversation dann, wenn sich aus den Umständen entnehmen lässt, dass der betroffene 
            Sachverhalt abschließend geklärt ist. Anfragen von Nutzern, die über einen Account bzw. Vertrag mit uns 
            verfügen, speichern wir bis zum Ablauf von zwei Jahren nach Vertragsbeendigung. Im Fall von gesetzlichen 
            Archivierungspflichten erfolgt die Löschung nach deren Ablauf: Ende handelsrechtlicher (6 Jahre) und 
            steuerrechtlicher (10 Jahre) Aufbewahrungspflicht.</p>
    </li>
    <li>Sie haben jederzeit die Möglichkeit, die Einwilligung nach Art. 6 Abs. 1 S. 1 lit. a) DS-GVO zur Verarbeitung 
        der personenbezogenen Daten zu widerrufen. Nehmen Sie per E-Mail Kontakt mit uns auf, so können Sie der 
        Speicherung der personenbezogenen Daten jederzeit widersprechen.</li>
</ol>
<p><strong>Rechte der betroffenen Person</strong></p>
<ol>
    <li>
        <p><strong>Widerspruch oder Widerruf gegen die Verarbeitung Ihrer Daten</strong><br>
            Soweit die Verarbeitung auf Ihrer Einwilligung gemäß Art. 6 Abs. 1 S. 1 lit. a), Art. 7 DS-GVO beruht, 
            haben Sie das Recht, die Einwilligung jederzeit zu widerrufen. Die Rechtmäßigkeit der aufgrund der 
            Einwilligung bis zum Widerruf erfolgten Verarbeitung wird dadurch nicht berührt.<br><br>
            Soweit wir die Verarbeitung Ihrer personenbezogenen Daten auf die Interessenabwägung gemäß Art. 6 Abs. 1 S. 
            1 lit. f) DS-GVO stützen, können Sie Widerspruch gegen die Verarbeitung einlegen. Dies ist der Fall, wenn 
            die Verarbeitung insbesondere nicht zur Erfüllung eines Vertrags mit Ihnen erforderlich ist, was von uns 
            jeweils bei der nachfolgenden Beschreibung der Funktionen dargestellt wird. Bei Ausübung eines solchen 
            Widerspruchs bitten wir um Darlegung der Gründe, weshalb wir Ihre personenbezogenen Daten nicht wie von uns 
            durchgeführt verarbeiten sollten. Im Falle Ihres begründeten Widerspruchs prüfen wir die Sachlage und 
            werden entweder die Datenverarbeitung einstellen bzw. anpassen oder Ihnen unsere zwingenden schutzwürdigen 
            Gründe aufzeigen, aufgrund derer wir die Verarbeitung fortführen.<br><br>
            Sie können der Verarbeitung Ihrer personenbezogenen Daten für Zwecke der Werbung und Datenanalyse jederzeit 
            widersprechen. Das Widerspruchsrecht können Sie kostenfrei ausüben. Über Ihren Werbewiderspruch können Sie 
            uns unter folgenden Kontaktdaten informieren:
            <br><br>
            <?php echo $impressum['responsible_name'] ??= 'PLATZHALTER'; ?><br>
            <?php echo $impressum['responsible_street'] ??= 'PLATZHALTER'; ?><br>
            <?php
                echo $impressum['responsible_postalCode'] ??= 'PLATZHALTER';
                echo ' ';
                echo $impressum['responsible_city'] ??= 'PLATZHALTER';
            ?><br>
            E-Mail: <a href="mailto:<?php echo $impressum['responsible_email'] ??= 'PLATZHALTER'; ?>">
                <?php echo $impressum['responsible_email'] ??= 'PLATZHALTER'; ?></a>
        </p>
    </li>
    <li>
        <p><strong>Recht auf Auskunft</strong><br>
            Sie haben das Recht, von uns eine Bestätigung darüber zu verlangen, ob Sie betreffende personenbezogene 
            Daten verarbeitet werden. Sofern dies der Fall ist, haben Sie ein Recht auf Auskunft über Ihre bei uns 
            gespeicherten persönlichen Daten nach Art. 15 DS-GVO. Dies beinhaltet insbesondere die Auskunft über die 
            Verarbeitungszwecke, die Kategorie der personenbezogenen Daten, die Kategorien von Empfängern, gegenüber 
            denen Ihre Daten offengelegt wurden oder werden, die geplante Speicherdauer, die Herkunft ihrer Daten, 
            sofern diese nicht direkt bei Ihnen erhoben wurden.
        </p>
    </li>
    <li>
        <p><strong>Recht auf Berichtigung</strong><br>
            Sie haben ein Recht auf Berichtigung unrichtiger oder auf Vervollständigung richtiger Daten nach Art. 16 
            DS-GVO. 
        </p>
    </li>
    <li>
        <p><strong>Recht auf Löschung</strong><br>
            Sie haben ein Recht auf Löschung Ihrer bei uns gespeicherten Daten nach Art. 17 DS-GVO, es sei denn 
            gesetzliche oder vertraglichen Aufbewahrungsfristen oder andere gesetzliche Pflichten bzw. Rechte zur 
            weiteren Speicherung stehen dieser entgegen. 
        </p>
    </li>
    <li>
        <p><strong>Recht auf Einschränkung</strong><br>
            Sie haben das Recht, eine Einschränkung bei der Verarbeitung Ihrer personenbezogenen Daten zu verlangen, 
            wenn eine der Voraussetzungen in Art. 18 Abs. 1 lit. a) bis d) DS-GVO erfüllt ist:
        </p>
        <ul>
            <li>Wenn Sie die Richtigkeit der Sie betreffenden personenbezogenen für eine Dauer bestreiten, die es dem 
                Verantwortlichen ermöglicht, die Richtigkeit der personenbezogenen Daten zu überprüfen;</li>
            <li>die Verarbeitung unrechtmäßig ist und Sie die Löschung der personenbezogenen Daten ablehnen und 
                stattdessen die Einschränkung der Nutzung der personenbezogenen Daten verlangen;</li>
            <li>der Verantwortliche die personenbezogenen Daten für die Zwecke der Verarbeitung nicht länger benötigt, 
                Sie diese jedoch zur Geltendmachung, Ausübung oder Verteidigung von Rechtsansprüchen benötigen, oder
            </li>
            <li>wenn Sie Widerspruch gegen die Verarbeitung gemäß Art. 21 Abs. 1 DS-GVO eingelegt haben und noch nicht 
                feststeht, ob die berechtigten Gründe des Verantwortlichen gegenüber Ihren Gründen überwiegen.</li>
        </ul>
    </li>
    <li>
        <p><strong>Recht auf Datenübertragbarkeit</strong><br>
            Sie haben ein Recht auf Datenübertragbarkeit nach Art. 20 DS-GVO, was bedeutet, dass Sie die bei uns über 
            Sie gespeicherten personenbezogenen Daten in einem strukturierten, gängigen und maschinenlesbaren Format 
            erhalten können oder die Übermittlung an einen anderen Verantwortlichen verlangen können. 
        </p>
    </li>
    <li><strong>Recht auf Beschwerde</strong><br>
        Sie haben ein Recht auf Beschwerde bei einer Aufsichtsbehörde. In der Regel können Sie sich hierfür an die 
        Aufsichtsbehörde insbesondere in dem Mitgliedstaat ihres Aufenthaltsorts, ihres Arbeitsplatzes oder des Orts 
        des mutmaßlichen Verstoßes wenden.
    </li>
</ol>
<p><strong>Datensicherheit</strong><br>
    Um alle personenbezogen Daten, die an uns übermittelt werden, zu schützen und um sicherzustellen, dass die 
    Datenschutzvorschriften von uns, aber auch unseren externen Dienstleistern eingehalten werden, haben wir geeignete 
    technische und organisatorische Sicherheitsmaßnahmen getroffen. Deshalb werden unter anderem alle Daten zwischen 
    Ihrem Browser und unserem Server über eine sichere SSL-Verbindung verschlüsselt übertragen.
</p>
<p>Stand: 11.08.2018</p>
<p>
    Quelle: <a href="https://www.juraforum.de/impressum-generator/">Impressum Vorlage von JuraForum.de</a>
</p>
  
<?php
    include 'Modules/footer.php';
?>
