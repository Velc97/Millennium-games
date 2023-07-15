



<tr><td class="ciano">Nessuna carta di credito inserita. Compila i form per memorizzarne una.<td></tr>
<tr><td> 
    <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
        <span style="color: #0074D9;">Nome propretario (max 300 caratteri): </span><input type="text" name="nomeProp" size="30" /><br />
        <span style="color: #0074D9;">Numero carta (esattamente 12 caratteri):</span><input type="text" name="numeroCarta" size="30" /><br />
        <span style="color: #0074D9;">Codice di sicurezza (esattamente 3 caratteri):</span><input type="text" name="sicCode" size="30" /><br />
        <span style="color: #0074D9;">Data di scadenza (formato YYYY-MM-DD):</span><input type="text" name="dataScad" size="30" /><br />
        <input type="submit" name="invio" alt="submit" value="Memorizza"/>
    </form> 
</td></tr>


