<?php

$city = new city($db);
$city->loadIssues(1);

unset($_SESSION['matricola']);

?>

<!DOCTYPE html>
<!--[if IEMobile 7 ]>    <html class="no-js iem7"> <![endif]-->
<!--[if (gt IEMobile 7)|!(IEMobile)]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>BIKE SHARING STATUS</title>
        <meta name="description" content="">
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="cleartype" content="on">

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/touch/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/touch/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/touch/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="img/touch/apple-touch-icon-57x57-precomposed.png">
        <link rel="shortcut icon" href="img/touch/apple-touch-icon.png">

        <!-- Tile icon for Win8 (144x144 + tile color) -->
        <meta name="msapplication-TileImage" content="img/touch/apple-touch-icon-144x144-precomposed.png">
        <meta name="msapplication-TileColor" content="#222222">


        <!-- For iOS web apps. Delete if not needed. https://github.com/h5bp/mobile-boilerplate/issues/94 -->
        <!--
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="apple-mobile-web-app-title" content="">
        -->

        <!-- This script prevents links from opening in Mobile Safari. https://gist.github.com/1042026 -->
        <!--
        <script>(function(a,b,c){if(c in b&&b[c]){var d,e=a.location,f=/^(a|html)$/i;a.addEventListener("click",function(a){d=a.target;while(!f.test(d.nodeName))d=d.parentNode;"href"in d&&(d.href.indexOf("http")||~d.href.indexOf(e.host))&&(a.preventDefault(),e.href=d.href)},!1)}})(document,window.navigator,"standalone")</script>
        -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    </head>
    <body>

        <!-- Add your site or application content here -->
        
        <h1>BIKEMI STATUS</h1>
        
        <?php if (isset($_SESSION['message'])) { ?>
        <div class="message">
        	<p><?php echo $_SESSION['message']; ?></p>
        </div>
        <?php 
        unset($_SESSION['message']);
        } ?>
        
        <ul class="tabs">
        	<li class="tab consulta active" rel="consulta"><span>Consulta</span></li>
        	<li class="tab segnala" rel="segnala"><span>Segnala</span></li>
        </ul>
        
        <section>
        	<article class="tab active" data-tab="consulta" id="consulta">
        		<form method="post">
	        		<span class="start">Prendi la bici</span>
	        		
	        		<div class="form">
		        		<p class="input">
		        			<label for="c_matricola">Matricola</label>
		        			<input type="tel" name="c_matricola" id="c_matricola" placeholder="Matricola" value="<?php echo (isset($_SESSION['matricola'])) ? $_SESSION['matricola'] : ''; ?>" />
		        		</p>
		        		<p class="button">
		        			<button type="submit">Consulta</button>
		        			<button class="taken">Presa</button>
		        		</p>
	        		</div>
	        		
	        		<input type="hidden" name="action" value="check" />
	        		
        		</form>
        		
        		<div id="responso">
        			<h3>STATO</h3>
        			<p class="clearfix"></p>
							<script type="text/html" id="issue-date-block">
								<div class="data">
									<h4 class="fromDate"><%= data_readable %></h4>
									<div class="issues">
									<% _.each(problems, function(i) { %>
										<div class="issue issue_<%= i.id_issue %>">
											<h4 class="name"><%= i.name %></h4>
											<p class="note"><%= i.note %></p>
										</div>
									<% }); %>
									</div>
								</div>
							</script>
        		</div>
        		
        	</article>
        	
        	<article class="tab" data-tab="segnala" id="segnala">
						<form method="post">

	        		<p class="input">
	        			<label for="s_matricola">Matricola</label>
	        			<input type="tel" name="s_matricola" id="s_matricola" placeholder="Matricola" value="<?php echo (isset($_SESSION['matricola'])) ? $_SESSION['matricola'] : ''; ?>" />
	        		</p>
							
							<p class="buttons">
								<button type="submit" class="ok">Nessun problema</button>
								<button class="problems">Segnala problemi <i></i></button>
							</p>
							
							<div class="problemi">
								<?php foreach ($city->issues as $i) { ?>
								<div class="issue">
			        		<p class="checkbox">
			        			<label for="issue_<?php echo $i->id_issue ?>"><?php echo $i->getName() ?></label>
			        			<input type="checkbox" name="issue[<?php echo $i->id_issue ?>]" id="issue_<?php echo $i->id_issue ?>" />
			        		</p>
			        		<p class="note">
			        			<input type="text" name="note[<?php echo $i->id_issue ?>]" id="note_<?php echo $i->id_issue ?>" placeholder="note aggiuntive" />
			        		</p>
								</div>
		        		<?php } ?>
		        		
		        		<button type="submit">Invia segnalazione</button>
		        		
							</div>
	        		
	        		<input type="hidden" name="status" value="1" /><!-- 1: ok | 2: problemi -->
	        		<input type="hidden" name="action" value="submit" />
        		
						</form>
        		
        	</article>
        	
        </section>
        
        
        <script src="js/vendor/zepto.min.js"></script>
        <script src="js/helper.js"></script>
<!-- 				<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script> -->
				<script src="js/vendor/jquery-2.0.3.min.js"></script>
        <script src="js/plugins.js"></script>
				<script>
					$(function() {
						
						// tabs
						$('article.tab:not(.active)').hide();
						$('ul.tabs li')
							.unbind('click')
							.bind('click', function() {

								$(this).siblings().removeClass('active');
								$(this).addClass('active');
								
								$('article.tab:not([data-tab="'+$(this).attr('rel')+'"])').hide();
								$('article.tab[data-tab="'+$(this).attr('rel')+'"]')
									.show()
									.find('p.input input')
									.focus();
								
							});
							
						init_consulta();
						init_segnala();
					});
					
					function init_consulta() {
						var base = $('article#consulta');
						var counter = 60;
						var intervallo = null;
						
						
						base
							.find('#responso, button.taken, div.form')
							.hide();
						base
							.find('#responso > div.data')
							.remove();						
						
						base
							.find('span.start')
							.removeClass('timer')
							.unbind('click')
							.bind('click', function(e) {
								e.preventDefault();
								
								base
									.find('span.start')
									.addClass('timer')
									.text(second2timer(counter));
									
								base
									.find('div.form')
									.show()
									.find('input#c_matricola')
									.focus();
								
								// timer
								var timer = counter;
								clearInterval(intervallo);
								intervallo = setInterval(function() {
									timer = timer-1;
									
									base
										.find('span.start')
										.text(second2timer(timer));
									if (timer == 0) {
										clearInterval(intervallo);
										alert('Tempo scaduto');
										$('#s_matricola, #c_matricola').val('');
										init_consulta();
									}
									
								}, 1000);
								
							});
						
						base
							.find('button[type="submit"]')
							.unbind('click')
							.bind('click', function(e) {
								e.preventDefault();
								
								base
									.find('button.taken, #responso')
									.show();
								
								var matricola = base.find('input[name="c_matricola"]').val();
								$('#s_matricola').val(matricola);
								$.get('/', {
									'action': 'check',
									'matricola': matricola
								}).done(function(data) {
									var tpl_data = _.template($('#issue-date-block').html());
									if (data.issues) {
										_.each(data.issues, function(a) {
											console.log(a);
											base
												.find('#responso')
												.find('p.clearfix')
												.before(tpl_data(a));
											
										});
																				
									}
								})
							})
							
						// presa
						base
							.find('button.taken')
							.unbind('click')
							.bind('click', function(e) {
								e.preventDefault();
								clearInterval(intervallo);
								$('ul.tabs li.segnala').click();
								init_consulta();
						});
					}
					
					function init_segnala() {
						var base = $('article#segnala');
						base
							.find('div.problemi')
							.hide()
							.find('div.issue')
							.each(function() {
								var issue = $(this);
								var note = issue.find('p.note');
								note.hide();
								issue
									.find('p.checkbox input')
									.bind('change', function() {
										note.toggle($(this).is(':checked'));
									})
							})
							
						base
							.find('p.buttons button.problems')
							.unbind('click')
							.bind('click', function(e) {
								e.preventDefault();
								
								base
									.find('div.problemi')
									.show();
									
								base
									.find('input[name="status"]')
									.val('0');
																	
							});

						base
							.find('p.buttons button.ok')
							.unbind('click')
							.bind('click', function(e) {
								e.preventDefault();
								
								base
									.find('div.problemi')
									.hide();
									
								base
									.find('input[name="status"]')
									.val('0');
									
								base
									.find('form')
									.submit();
																	
							});

					}
					
					function zerofill(numero, cifre) {
						var out = (new Array(cifre + 1 - numero.toString().length)).join('0') + numero;
						return out;
					}
					
					function second2timer(timer) {
						var minuti = Math.floor(timer/60);
						var secondi = timer % 60;
						var text = zerofill(minuti,2)+':'+zerofill(secondi,2);
						return text;
					}
				</script>
				
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <!--
        <script>
            var _gaq=[["_setAccount","UA-XXXXX-X"],["_trackPageview"]];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
            g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
            s.parentNode.insertBefore(g,s)}(document,"script"));
        </script>
        -->
    </body>
</html>
