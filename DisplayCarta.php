<tr><td class="ciano">Nome proprietario: ". $riga['nomePro'] . "</td></tr>
            <tr><td class="ciano">Numero carta: ". $riga['numeroCarta'] . "</td></tr>
            <tr><td class="ciano">Cod Sicurezza: ". $riga['codSic'] . "</td></tr>
            <tr><td class="ciano">Data scadenza: ". $riga['dataScad'] . "</td></tr>
            <tr><td>
                <form action= <?php $_SERVER['PHP_SELF'] ?> method="post">
                    <input type="submit" class="bottone" name="CancellaCarta" value="Cancella carta" alt="submit"/>
                </form>
            </td></tr>"