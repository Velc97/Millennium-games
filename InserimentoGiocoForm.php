<table style="border:3px solid black; background-color: #001f3f; margin: 0 auto;">
    <tr><td class="ciano" style="border: 6px solid black;">
            <p style="color:#0074D9;">Compilare tutti i seguenti campi per aggiungere il videogioco.</p>
            <form action="<?php $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
                <span>ID </span><input type="text" name="IDgioco" size="30" value="<?php if(isset($_POST['IDgioco'])) {echo htmlentities($_POST['IDgioco']);} ?>"/><br />
                <span>Titolo </span><input type="text" name="NOMEgioco" size="30" value="<?php if(isset($_POST['NOMEgioco'])) {echo htmlentities($_POST['NOMEgioco']);} ?>"/><br />
                <span>Genere </span><input type="text" name="GENEREgioco" size="30" value="<?php if(isset($_POST['GENEREgioco'])) {echo htmlentities($_POST['GENEREgioco']);} ?>" /><br />
                <span>Descrizione </span><br /><textarea rows=3 cols=60 name=DESCRIZIONEgioco > <?php if(isset($_POST['DESCRIZIONEgioco'])) {echo htmlentities($_POST['DESCRIZIONEgioco']);} ?></textarea><br />
                <span>Prezzo </span><input type="text" name="PREZZOgioco" size="30" value="<?php if(isset($_POST['PREZZOgioco'])) {echo htmlentities($_POST['PREZZOgioco']);} ?>" /><br />
                <span>Disponibilit&agrave; </span><input type="text" name="DISPOgioco" size="30" value="<?php if(isset($_POST['DISPOgioco'])) {echo htmlentities($_POST['DISPOgioco']);} ?>" /><br />
                <p style="color:#0074D9;">Inserire da 0 a 4 immagini .jpg</p>
                <input type="file" name="fileToUpload[]" id="fileToUpload" multiple/>
                <input type="submit" name="aggGioco" alt="submit" value="Aggiungi Gioco"/>
            </form>
    </td></tr>
</table>

<?php


    if(isset($_POST['aggGioco']))
        {
         if(!empty($_POST['IDgioco']) && !empty($_POST['NOMEgioco']) && !empty($_POST['GENEREgioco']) && !empty($_POST['DESCRIZIONEgioco']) && !empty($_POST['PREZZOgioco']) && !empty($_POST['DISPOgioco']))
            {
                $dir = "games/". $_POST['IDgioco'];
                if(file_exists($dir))
                    {echo "<p style=\"color:red;\"> L'id esiste gi&agrave;. Sceglierne un altro.</p>"; exit();}
                mkdir($dir, 0700, true);

                $contenutoXML="";
                foreach (file("SpecificaDatiVideogiochi.xml") as $nodo)
                           {$contenutoXML .= trim($nodo);}
                $documentoXML = new DOMDocument();
                $documentoXML->loadXML($contenutoXML);

                $TAG_Videgioco = $documentoXML->createElement("Videogioco");
                $TAG_IDgioco = $documentoXML->createElement("idGioco", $_POST['IDgioco']);
                $TAG_NOMEgioco = $documentoXML->createElement("nomeGioco", $_POST['NOMEgioco']);
                $TAG_GENEREgioco = $documentoXML->createElement("genere", $_POST['GENEREgioco']);
                $TAG_DESCRIZIONEgioco = $documentoXML->createElement("descrizione", $_POST['DESCRIZIONEgioco']);
                $TAG_PREZZOgioco = $documentoXML->createElement("prezzo", $_POST['PREZZOgioco']);
                $TAG_DISPOgioco = $documentoXML->createElement("dispo", $_POST['DISPOgioco']);

                $radice = $documentoXML->getElementsByTagName("VIDEOGIOCHI")->item(0);
                $radice->appendChild($TAG_Videgioco);
                $TAG_Videgioco->appendChild($TAG_IDgioco);
                $TAG_Videgioco->appendChild($TAG_NOMEgioco);
                $TAG_Videgioco->appendChild($TAG_GENEREgioco);
                $TAG_Videgioco->appendChild($TAG_DESCRIZIONEgioco);
                $TAG_Videgioco->appendChild($TAG_PREZZOgioco);
                
                

                if(is_uploaded_file($_FILES['fileToUpload']['tmp_name'][0])) /*Caso di caricamento dei file */
                       {
                        $nfile = count($_FILES['fileToUpload']['name']);
                        echo $nfile;
                        $uploadPossibile=1;
                        for($i=0; $i<$nfile; $i++)
                           {
                            $file_bersaglio = $dir . "/" . basename($_FILES['fileToUpload']['name'][$i]);
                            $imageFileType = strtolower(pathinfo($file_bersaglio, PATHINFO_EXTENSION));
                            if($imageFileType != "jpg")
                               {echo "Il file deve essere in formato jpg. Caricamento delle immagini non effettuato"; $uploadPossibile=0; $i=$nfile;}
                            $i++; $file_bersaglio = $dir. "/sc". $i .".jpg"; $i--;
       
                            /*Se tutto è andato a buon fine, memorizzo le immagini */
                            if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'][$i], $file_bersaglio) && $uploadPossibile==1)
                               {
                                $i++;
                                $TAG_img =$documentoXML->createElement("img","sc". $i .".jpg");
                                $i--;
                                $TAG_Videgioco->appendChild($TAG_img);
                               }
                            else{echo "errore upload file numero ".$i;}        
                           }
                       }

                $TAG_Videgioco->appendChild($TAG_DISPOgioco);
                $documentoXML->save("SpecificaDatiVideogiochi.xml");
                echo "<p style=\"color:green;\"> Gioco inserito con successo!</p>";
            }
         else 
		 {
          $error ="";
          $error .= "<p style=\"color:red;\">Compilare i seguenti campi:<br />";
          if(empty($_POST['IDgioco'])) {$error .="ID del gioco<br />";}
          if(empty($_POST['NOMEgioco'])) {$error .= "Nome del gioco<br />";}
          if(empty($_POST['GENEREgioco'])) {$error .= "Genere del gioco<br />";}
          if(empty($_POST['DESCRIZIONEgioco'])) {$error .= "Descrizione del gioco <br />";}
          if(empty($_POST['PREZZOgioco'])) {$error .= "Prezzo del gioco <br />";}
          if(empty($_POST['DISPOgioco'])) {$error .= "Data di disponibilit&agrave; del gioco <br />";}
          $error .= "</p>";
          echo $error;
		 }
        }
    
?>