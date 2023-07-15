<!--Questo file serve ad aggiungere una riga alla tabella di login.-->
<tr> 
	<td style="border-top: 4px dotted black;" colspan="2">
		<h2 style="color: #0074D9; text-align: center;"> Registrazione </h2>
		<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
			<span style="color: #0074D9;"> Nome utente: </span> <input type="text" name="userNameReg" size="30"/> <br />
			<span style="color: #0074D9;"> Password: </span> <input type="password" name="pass1" size="30"/> <br />
			<span style="color: #0074D9;"> Conferma password: </span> <input type="password" name="pass2" size="30"/> <br/>
			<input type="submit" class="bottone" name="ConfermaReg" value="Registrati!"/>
		</form>
	</td>
</tr>