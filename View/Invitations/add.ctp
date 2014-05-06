
<p><?= __( "Por favor introduce el email de tu amigo")?></p>
<?= $this->Form->create( 'Invitation') ?>
<?= $this->Form->input('Invitation.email', array(
      'label' => __( "Email"), 
))?>
<?= $this->Form->submit( __( 'Enviar invitación')) ?>
<?= $this->Form->end() ?>


