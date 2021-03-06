<!doctype html>
<html lang="en">
	<head>
		<?= $this->Html->charset() ?>

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="wardx">
		
		<?= $this->fetch('meta') ?>

		<title><?= $this->fetch('title') ?></title>

		<?= $this->Html->css('bootstrap/bootstrap.min.css') ?>

		<?= $this->Html->css('bootstrap-big-grid.min.css') ?>

		<?= $this->Html->css('bootstrap-datepicker/bootstrap-datepicker.standalone.min.css') ?>

		<?= $this->Html->css('jquery-jvectormap-2.0.5.css') ?>

		<?= $this->Html->css('dashboard.css') ?>

		<?= $this->Html->css('main.css') ?>

		<?= $this->fetch('css') ?>


		<?= $this->Html->script('jquery-3.4.1.min.js') ?>

		<?= $this->Html->script('moment.js') ?>

		<?= $this->Html->script('bootstrap/bootstrap.bundle.min.js') ?>

		<?= $this->Html->script('bootstrap-datepicker/bootstrap-datepicker.min.js') ?>
		
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script> -->
		<?= $this->Html->script('feather.min.js') ?>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script> -->
		<?= $this->Html->script('Chart.min.js') ?>
		<!-- <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script> -->
		<?= $this->Html->script('ckeditor.js') ?>

		<?= $this->Html->script('jquery-jvectormap-2.0.5.min.js') ?>

		<?= $this->fetch('script') ?>

		<!-- Favicons -->
		<!-- <link rel="apple-touch-icon" href="/docs/4.4/assets/img/favicons/apple-touch-icon.png" sizes="180x180"> -->
		<!-- <link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png"> -->
		<!-- <link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png"> -->
		<!-- <link rel="manifest" href="/docs/4.4/assets/img/favicons/manifest.json"> -->
		<!-- <link rel="mask-icon" href="/docs/4.4/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c"> -->
		<!-- <link rel="icon" href="/docs/4.4/assets/img/favicons/favicon.ico"> -->
		<!-- <meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml"> -->
		<!-- <meta name="theme-color" content="#563d7c"> -->

	</head>
	<body>
		<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
			<a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
			<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
			
			<ul class="navbar-nav px-3">
				<li class="nav-item text-nowrap"><a class="nav-link" href="#">Sign out</a></li>
			</ul>
		</nav>

		<div class="container-fluid">
  			<div class="row">
				<nav class="col-md-2 d-none d-md-block bg-light sidebar">
	  				<div class="sidebar-sticky">
						
						<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
							<span>Main menu</span>
						</h6>

						<?php $controller = $this->request->getParam('controller'); ?>
						<?php $action = $this->request->getParam('action'); ?>

						<ul class="nav flex-column">
							<li class="nav-item <?= $controller=="Dashboard" ? "active" : "" ?>">
								<a class="nav-link" href="<?= $this->Url->build('/dashboard') ?>">
									<span data-feather="home"></span> Dashboard <span class="sr-only">(current)</span>
								</a>
							</li>
							<li class="nav-item <?= $controller=="Articles" ? "active" : "" ?>">
								<a class="nav-link" href="<?= $this->Url->build('/articles') ?>">
									<span data-feather="file"></span> Articles
								</a>
							</li>
							<li class="nav-item <?= $controller=="Settlement" ? "active" : "" ?>">
								<a class="nav-link" href="<?= $this->Url->build('/settlement') ?>">
									<span data-feather="trello"></span> Settlement
								</a>

								<ul class="nav subnav flex-column">
									<li class="nav-item <?= $action=="dupa" ? "active" : "" ?>">
										<a class="nav-link" href="#">
											<span data-feather="bar-chart-2"></span> Submenu 1
										</a>
									</li>
									<li class="nav-item <?= $action=="new" ? "active" : "" ?>">
										<a class="nav-link" href="#">
											<span data-feather="layers"></span> Submenu 2
										</a>
									</li>
								</ul>
							</li>
							<li class="nav-item <?= $controller=="Covid" ? "active" : "" ?>">
								<a class="nav-link" href="<?= $this->Url->build('/covid') ?>">
									<span data-feather="loader"></span> COVID-19
								</a>

								<ul class="nav subnav flex-column">
									<li class="nav-item <?= $action=="index" || $action=="poland" ? "active" : "" ?>">
										<a class="nav-link" href="<?= $this->Url->build('/covid') ?>">
											<span data-feather="bar-chart-2"></span> Poland
										</a>
									</li>
									<li class="nav-item <?= $action=="global" ? "active" : "" ?>">
										<a class="nav-link" href="<?= $this->Url->build('/covid/global') ?>">
											<span data-feather="layers"></span> World
										</a>
									</li>
								</ul>
							</li>
						</ul>

						<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
							<span>Submenu</span>
						</h6>
						
						<ul class="nav flex-column">
							<li class="nav-item">
								<a class="nav-link" href="#">
									<span data-feather="file"></span> Orders
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">
									<span data-feather="shopping-cart"></span> Products
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">
									<span data-feather="users"></span> Customers
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">
									<span data-feather="bar-chart-2"></span> Reports
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">
									<span data-feather="layers"></span> Integrations
								</a>
							</li>
						</ul>

						<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
							<span>Saved reports</span>
							<a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
								<span data-feather="plus-circle"></span>
							</a>
						</h6>

						<ul class="nav flex-column mb-2">
							<li class="nav-item">
								<a class="nav-link" href="#">
									<span data-feather="file-text"></span> Current month
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">
									<span data-feather="file-text"></span> Last quarter
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">
									<span data-feather="file-text"></span> Social engagement
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">
									<span data-feather="file-text"></span> Year-end sale
								</a>
							</li>
						</ul>

					</div>
				</nav>

				<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">

					<?= $this->Flash->render() ?>

					<?= $this->fetch('content') ?>

					<pre><?= print_r($this->request->getParam('controller'), true) ?></pre>

				</main>

			</div>
		</div>

		<?= $this->Html->script('dashboard.js') ?>
	</body>
</html>

