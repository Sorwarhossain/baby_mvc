<?php
/** @var $model App\Models\User */
?>
<section class="contact py-5">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Register Your Account</h1>
                <?php $form = \App\Core\Forms\Form::begin('', 'post'); ?>
                    <?php echo $form->field($model, 'firstname', 'First Name'); ?>
                    <?php echo $form->field($model, 'lastname', 'Last Name'); ?>
                    <?php echo $form->field($model, 'email', 'Email')->fieldType('email'); ?>
                    <?php echo $form->field($model, 'password', 'Password')->fieldType('password'); ?>
                    <?php echo $form->field($model, 'confirmPassword', 'Confirm Password')->fieldType('password'); ?>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                <?php echo \App\Core\Forms\Form::end(); ?>
            </div>
        </div>
    </div>
</section>