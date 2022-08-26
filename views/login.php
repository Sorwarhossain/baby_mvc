<?php
/** @var $model App\Models\User */
?>
<section class="contact py-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Login To Your Account</h1>
                <?php $form = \App\Core\Forms\Form::begin('', 'post'); ?>
                <?php echo $form->field($model, 'email', 'Email')->fieldType('email'); ?>
                <?php echo $form->field($model, 'password', 'Password')->fieldType('password'); ?>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                <?php echo \App\Core\Forms\Form::end(); ?>
            </div>
        </div>
    </div>
</section>