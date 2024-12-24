<h2>Login into your account.</h2>

<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<form action="/login" method="post">
    <?= csrf_field() ?>

    <label for="username">Username : </label>
    <input type="input" name="username" value="<?= set_value('username') ?>">
    <br>

    <label for="password">Password : </label>
    <input type="password" name="password" value="<?= set_value('password') ?>">
    <br>

    <input type="submit" name="submit" value="Log In">
</form>

<a href="<?= base_url('/googleLogin'); ?>">
    <button type="button">Sign in with Google</button>
</a>