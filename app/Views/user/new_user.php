<h2>Create an account.</h2>

<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<form action="/register" method="post">
    <?= csrf_field() ?>

    <label for="username">Username : </label>
    <input type="input" name="username" value="<?= set_value('username') ?>">
    <br>

    <label for="email">Email : </label>
    <input type="input" name="email" value="<?= set_value('email') ?>">
    <br>

    <label for="password">Password : </label>
    <input type="password" name="password" value="<?= set_value('password') ?>">
    <br>

    <input type="submit" name="submit" value="Create">
</form>