@php use function Symfony\Component\String\b; @endphp
<html>
<head>
    <style>
        body {
            font-family: Maiandra GD;
            font-size: 18;
            width: 90%;
            margin: auto;
        }

        td, th {
            border: 1px solid black;
            font-family: "Maiandra GD", serif;
            text-align: center; /* Tous les textes des cellules seront centrés*/
            padding: 5px;
        }

        #signature {

            position: absolute;
            bottom: 0;
            width: 100%;
            top: 1300px;
            height: 100px;
        }
    </style>
</head>
<body onafterprint="redirectBack()">
<div id="print">
    <div id="entete" style="height:230px;"></div>

    <center>
        <p style="text-align:center; font-family:Maiandra GD;font-size:1.6em;border-bottom:2px  double black;width:60%;">
            Faculté des Sciences Informatiques</p>

        <p>
        <h3>RELEVE DES COTES N°.........../UPL/SGAC/FI/{{date("Y") - 1 . '-' . date("Y")}}</p></h3></center>

    <p style="text-align:justify; line-height: 1.5;">Monsieur / Madame :
        <strong>{{$mention->etudiant->nom}}</strong> Matricule<strong> {{$mention->etudiant->matricule}} </strong>
        Né (e) à <strong>{{$demande->lieu_naissance??"[Lieu de naissance]"}}</strong> le
        <strong>{{$demande->date_naissance??"[Date de naissance]"}}</strong>, a obtenu(e) à
        l'issu <strong>{{$mention->msession}}</strong>
        de l'année académique <strong>{{$mention->annee}}</strong> les cotes ci-dessous reprises aux examens portant sur
        les matières prévues au programme de <strong> {{$grade}}</strong> Option
        <strong>{{$demande->filiere_code??$filiere}} </strong> à
        la Faculté
        des <strong>{{$demande->faculte->nom??"Science Informatiques"}}</strong> :

    </p>
    <div id="tableau">
        <table border="1" style="border-collapse:collapse; text-align:justify;font-size : 16; font-weight:bold; padding:10px; margin: auto; border: 1px outset black;
   border-collapse: collapse;">
            <caption></caption>
            <thead>
            <tr style="">
                <th style="text-align:center;" rowspan="2" colspan="1">N°</th>
                <th rowspan="2" colspan="1" style="text-align:center; width:600px;">COURS</th>
                <th rowspan="1" colspan="4" style="text-align:center;">VOLUME HORAIRE</th>
                <th rowspan="2" colspan="1" style="text-align:center;">CREDITS</th>
                <th rowspan="2" colspan="1" style="text-align:center;">
                    COTES OBTENUES/20
                </th>
            </tr>
            <tr>
                <td style="text-align:center;">C.M</td>
                <td style="text-align:center;">T.D</td>
                <td style="text-align:center;">T.P</td>
                <td style="text-align:center;">T.P.E</td>
            </tr>
            </thead>
            <tbody>
            @foreach($cotations as $key=>$cotation)
                <tr>
                    <td>{{$key+1}}</td>
                    <td style="text-align:justify">{{$cotation->cours->course_name}}</td>
                    <td>{{$cotation->cours->cm}}</td>
                    <td>{{$cotation->cours->td}}</td>
                    <td>{{$cotation->cours->tp}}</td>
                    <td>{{$cotation->cours->tpe}}</td>
                    <td style="text-align:center;">{{$cotation->cours->course_credits}}</td>
                    <td style="text-align:center;">{{$cotation->note}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <pre>
                         MOYENNE PONDEREE..................<strong> {{$mention->moyenne_ponderee}}/20</strong>
                         POURCENTAGE.......................<strong> {{$mention->pourcentage}}</strong>
                         CREDITS VALIDES...................<strong> {{$mention->credits_valide}}/60</strong>
                         DECISION DU JURY : <strong>{{$mention->decision}}</strong>
 </pre>
    </div>
    <div id="signature">
<pre><strong>                                                                       Fait à Lubumbashi, le {{date("d/m/Y")}}  .

SECRETAIRE DE LA FACULTE                                                     DOYEN DE LA FACULTE




{{$demande->filiere_code??$filiere=='RT'?'Ir. Rose KAMWANG':'Ir. Franck TSHIBUABUA'}}                                                      Msc. Daniel KAPEND KATUAL
                                                                                  Chef de Travaux</strong>
      </pre>
    </div>
    <script>
        window.print();

        function redirectBack() {
            location.replace("{{back()->getTargetUrl()}}");
        }
    </script>
</div>
</body>
</html>


