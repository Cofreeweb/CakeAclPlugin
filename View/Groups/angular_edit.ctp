<form ng-submit="submit( 'edit')" name="sectionsForm">
  <?= $this->Form->input( 'Group.name', array(
      'name' => 'name',
      'ng-model' => 'data.Group.name',
      'label' => 'Nombre',
  )) ?>
  
  <label ng-repeat="permission in permissions">
    <input type="checkbox" checklist-model="data.Group.permissions" checklist-value="permission.id" />{{permission.label}}
  </label>
  
  <input type="submit" id="submit" value="Submit" />
</form>