<? $this->AdminNav->setTitle( __d( 'admin', 'Usuarios'), __d( 'admin', 'Crear'), 'user') ?>

<div class="groups form">

<?= $this->Form->create( 'User', array(
    'class' => 'form-horizontal'
)) ?>
  
  <?= $this->Form->hidden( 'User.id') ?>
  
  <?= $this->Form->input( 'User.name', array(
      'type' => 'text',
      'label' => 'Nombre'
  )) ?>

  <?= $this->Form->input( 'User.email', array(
      'type' => 'text',
      'label' => 'Email'
  )) ?>
  
  <?= $this->Form->input( 'User.group_id', array(
      'type' => 'select',
      'label' => 'Grupo'
  )) ?>
  
  <?= $this->Form->input( 'User.status', array(
      'type' => 'checkbox',
      'label' => 'Activo',
      'class' => 'ace'
  )) ?>
  
  <?= $this->Form->input( 'User.password', array(
      'label' => __d( 'admin', "Contraseña"),
      'required' => false
  )) ?>
  
  <?= $this->Form->input( 'User.password2', array(
      'type' => 'password',
      'label' => __d( 'admin', "Repite la contraseña"),
      'required' => false
  )) ?>
  
	<?= $this->Form->submit( __d( 'admin', 'Crear usuario')) ?>
<?= $this->Form->end();?>
</div>