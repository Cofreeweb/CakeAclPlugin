<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="login-container">
			<div class="center">
				<h1>
					<span class="green"><i class="icon-cog white"></i> <?= Configure::read( 'Config.siteName') ?></span>
					<span class="white"><?= __d( 'admin', 'Entrada') ?></span>
				</h1>
			</div>

			<div class="space-6"></div>

			<div class="position-relative">
				<div id="login-box" class="login-box visible widget-box no-border">
					<div class="widget-body">
						<div class="widget-main">
							<h4 class="header blue lighter bigger">
								<i class="icon-arrow-down green"></i>
								<?= __( "Por favor, introduzca los datos")?>
							</h4>

							<div class="space-6"></div>

							<?= $this->Form->create( 'User') ?>
								<fieldset>
									<label class="block clearfix">
										<span class="block input-icon input-icon-right">
											<?= $this->Form->input( 'User.email', array(
                        'label' => false,
                        'div' => false,
                        'class' => 'form-control',
                        'placeholder' => __( "Email"),
                        'type' => 'text'
											))?>
											<i class="icon-user"></i>
										</span>
									</label>

									<label class="block clearfix">
										<span class="block input-icon input-icon-right">
											<?= $this->Form->input( 'User.password', array(
                        'label' => false,
                        'div' => false,
                        'class' => 'form-control',
                        'placeholder' => __( "Contraseña"),
                        'type' => 'password'
											))?>
											<i class="icon-lock"></i>
										</span>
									</label>

									<div class="space"></div>

									<div class="clearfix">
										<label class="inline">
											<input type="checkbox" class="ace" />
											<span class="lbl"> <?= __( "Recordar")?></span>
										</label>

										<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
											<i class="icon-key"></i>
											<?= __( "Entrar") ?>
										</button>
									</div>

									<div class="space-4"></div>
								</fieldset>
              <?= $this->Form->end() ?>
						</div><!-- /widget-main -->

						<div class="toolbar clearfix">
							<div class="col-md-9">
								<a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link white">
									<i class="icon-arrow-left"></i>
									<?= __( "He olvidado mi contraseña")?>
								</a>
							</div>
						</div>
					</div><!-- /widget-body -->
				</div><!-- /login-box -->
			</div><!-- /position-relative -->
		</div>
	</div><!-- /.col -->
</div><!-- /.row -->