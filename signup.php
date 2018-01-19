<form action="account_signup.php" method="POST">
	<input type="text" name="user_name" placeholder="Nume utilizator" pattern=".{6,}" required="required">
	<input type="text" name="email" placeholder="Adresa email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required="required">
	<input type="password" name="password" pattern=".{6,}" required="required">
	<input type="submit" name="Login">
</form>