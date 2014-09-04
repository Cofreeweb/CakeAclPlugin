<div class="groups form">
<?= $this->Form->create( 'Group', array(
    'class' => 'form-horizontal'
)) ?>
    <?= $this->Form->hidden( 'Group.id') ?>
    <?= $this->Form->input( 'Group.name', array(
        'type' => 'text',
        'label' => 'Nombre'
    )) ?>

    <?= $this->Form->input( 'Group.level', array(
        'type' => 'text',
        'label' => 'Level',
    )) ?>
    
    <div class="col-md-offset-2 col-md-2">
      <?= $this->Form->submit( __d( 'admin', 'Guardar')) ?>
    </div>
<?= $this->Form->end() ?>
</div>
