<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="login-container">
			<div class="center">
				<h1>
					<span class="white"><?= __d( 'admin', 'Recuperar contraseña') ?></span>
				</h1>
			</div>

			<div class="space-6"></div>

			<div class="position-relative">
				<div id="login-box" class="login-box visible widget-box no-border">
					<div class="widget-body">
						<div class="widget-main">
							<h4 class="header blue lighter bigger">
								<i class="icon-arrow-down green"></i>
								<?= __( "Por favor, introduce los datos")?>
							</h4>

							<div class="space-6"></div>

							<?= $this->Form->create( 'User') ?>
								<fieldset>
									<label class="block clearfix">
										<span class="block input-icon input-icon-right">
											<?= $this->Form->input( 'User.password', array(
                        'label' => false,
                        'div' => false,
                        'class' => 'form-control',
                        'placeholder' => __( "Contraseña"),
                        'type' => 'password'
											))?>
											<i class="icon-user"></i>
										</span>
									</label>
								  
								  <label class="block clearfix">
										<span class="block input-icon input-icon-right">
											<?= $this->Form->input( 'User.password2', array(
                        'label' => false,
                        'div' => false,
                        'class' => 'form-control',
                        'placeholder' => __( "Repite contraseña"),
                        'type' => 'password'
											))?>
											<i class="icon-user"></i>
										</span>
									</label>
									
									<div class="space"></div>
									<div class="clearfix">
										<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
											<i class="icon-key"></i>
											<?= __( "Enviar") ?>
										</button>
									</div>

									<div class="space-4"></div>
								</fieldset>
								<?php echo $this->Form->hidden('ident', array('value' => $ident)); ?>
                <?php echo $this->Form->hidden('activate', array('value' => $activate)); ?>
              <?= $this->Form->end() ?>
						</div><!-- /widget-main -->

					</div><!-- /widget-body -->
				</div><!-- /login-box -->
			</div><!-- /position-relative -->
		</div>
	</div><!-- /.col -->
</div><!-- /.row -->