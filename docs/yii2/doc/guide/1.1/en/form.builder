<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    	<meta charset="UTF-8" />
		<meta name="keywords" content="yii framework, tutorial, guide, version 1.1" />
	<meta name="description" content="When creating HTML forms, we often find that we are writing a lot of repetitive view code
which is difficult to be reused in a different project." />
    <link rel="shortcut icon" type="image/x-icon" href="http://static.yiiframework.com/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="http://static.yiiframework.com/css/site-20130404102234.css" />

	<link title="Lives News for Yii Framework" rel="alternate" type="application/rss+xml" href="http://www.yiiframework.com/rss.xml/" />
	<title>Working with Forms: Using Form Builder | The Definitive Guide to Yii | Yii PHP Framework</title>
	<link rel="search" type="application/opensearchdescription+xml" title="Yii API Search" href="/search-api.xml" />
	<link rel="search" type="application/opensearchdescription+xml" title="Yii Site Search" href="/search-site.xml" />
</head>

<body class="mac">
<div class="layout-main">

	<div class="layout-main-shortcuts">
		<div class="container_12">
            <a style="color:darkred;" href="https://github.com/yiisoft/yii2">Github</a> &middot;
            <a style="color:darkgreen;" href="https://twitter.com/yiiframework">Twitter</a> &middot;
            <a style="color:darkblue;" href="https://www.facebook.com/groups/yiitalk/">Facebook</a> &middot;
            <a href="/doc/guide/">Guide</a> &middot;
            <a href="/doc/api/">Class Reference</a> &middot;
            <a href="/doc-2.0/guide-index.html">Guide 2.0</a> &middot;
            <a href="/doc-2.0/index.html">API 2.0</a> &middot;
            <a href="/wiki/">Wiki</a> &middot;
            <a href="/extensions/">Extensions</a> &middot;
            <a href="/forum/">Forum</a> &middot;
			<a href="/chat/">Live Chat</a> &middot;
                            <a href="/login/">Login</a>            		</div>
	</div>

	<div class="layout-main-bg">
		<div class="layout-main-header">
			<div class="container_12">
				<div class="grid_4">
					<a class="logo" href="/"><img alt="Yii Logo" src="http://static.yiiframework.com/css/img/logo.png" title="Yii Framework" width="284" height="64" /></a>				</div>
				<div class="grid_8 omega">
					<div class="nav">
						<ul class="menu" id="yw0">
<li class="about"><a class="main" href="/about/">About</a>
<ul>
<li><a href="/about/">About Yii</a></li>
<li><a href="/features/">Features</a></li>
<li><a href="/performance/">Performance</a></li>
<li><a href="/license/">License</a></li>
<li class="last"><a href="/contact/">Contact Us</a></li>
</ul>
</li>
<li class="downloads"><a class="main" href="/download/">Downloads</a>
<ul>
<li><a href="/download/">Framework</a></li>
<li><a href="/extensions/">Extensions</a></li>
<li><a href="/demos/">Demos</a></li>
<li class="last"><a href="/logo/">Logo</a></li>
</ul>
</li>
<li class="documentation active"><a class="main" href="/doc/">Documentation</a>
<ul>
<li><a href="/tour/">Take the Tour</a></li>
<li class="active"><a href="/tutorials/">Tutorials</a></li>
<li><a href="/doc/api/">Class Reference</a></li>
<li><a href="/doc-2.0/guide-index.html">Guide 2.0</a></li>
<li><a href="/doc-2.0/index.html">Class Reference 2.0</a></li>
<li><a href="/wiki/">Wiki</a></li>
<li><a href="/screencasts/">Screencasts</a></li>
<li class="last"><a href="/resources/">Resources</a></li>
</ul>
</li>
<li class="development"><a class="main" href="https://github.com/yiisoft/yii/commits/master">Development</a>
<ul>
<li><a href="/contribute/">Contribute to Yii</a></li>
<li><a href="https://github.com/yiisoft/yii/commits/master">Latest Updates</a></li>
<li><a href="https://github.com/yiisoft/yii/issues/new">Report a Bug</a></li>
<li class="last"><a href="/security/">Report a Security Issue</a></li>
</ul>
</li>
<li class="community last"><a class="main" href="/community/">Community</a>
<ul>
<li><a href="/forum/">Forum</a></li>
<li><a href="/chat/">Live Chat</a></li>
<li><a href="/news/">News</a></li>
<li><a href="/user/halloffame/">Hall of Fame</a></li>
<li class="last"><a href="/badges/">Badges</a></li>
</ul>
</li>
</ul>						<div class="search">
							<form method="get" action="/search/">
								<div class="keyword">
	                                <input name="q" value="" />
									<a href="#" title="search" class="global-search">search</a>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>

		<div class="container_12">
						<div class="grid_12">
												<div class="layout-main-submenu">
					<ul>
						<li class="main">Documentation</li>
												<li><a href="/tour/">Take the Tour</a></li>
												<li class="active"><a href="/tutorials/">Tutorials</a></li>
												<li><a href="/doc/api/">Class Reference</a></li>
												<li><a href="/doc-2.0/guide-index.html">Guide 2.0</a></li>
												<li><a href="/doc-2.0/index.html">Class Reference 2.0</a></li>
												<li><a href="/wiki/">Wiki</a></li>
												<li><a href="/screencasts/">Screencasts</a></li>
												<li><a href="/resources/">Resources</a></li>
											</ul>
				</div>
				
				
				
									<div class="layout-main-body">
						<div class="tutorial-view">
    <div class="grid_3 alpha">
        <div class="nav-toc">
    		<div class="title">The Definitive Guide to Yii</div>
    		<div class="langver">
	            <strong>Language &amp; version</strong>
	    		<div class="languages g-dropdown">
	    		<span>English<i></i></span>
<ul>
<li><a href="/doc/guide/1.1/de/form.builder">Deutsch</a></li>
<li><a href="/doc/guide/1.1/es/form.builder">Español</a></li>
<li><a href="/doc/guide/1.1/fr/form.builder">Français</a></li>
<li><a href="/doc/guide/1.1/he/form.builder">עִבְרִית</a></li>
<li><a href="/doc/guide/1.1/id/form.builder">Bahasa Indonesia</a></li>
<li><a href="/doc/guide/1.1/it/form.builder">Italiano</a></li>
<li><a href="/doc/guide/1.1/ja/form.builder">日本語</a></li>
<li><a href="/doc/guide/1.1/pl/form.builder">Polski</a></li>
<li><a href="/doc/guide/1.1/pt/form.builder">Português</a></li>
<li><a href="/doc/guide/1.1/pt_br/form.builder">Português brasileiro</a></li>
<li><a href="/doc/guide/1.1/ro/form.builder">România</a></li>
<li><a href="/doc/guide/1.1/ru/form.builder">Русский</a></li>
<li><a href="/doc/guide/1.1/sv/form.builder">Svenska</a></li>
<li><a href="/doc/guide/1.1/uk/form.builder">украї́нська</a></li>
<li><a href="/doc/guide/1.1/zh_cn/form.builder">简体中文</a></li>
</ul>
	    		</div>
				<div class="versions g-dropdown">
	    		<span>1.1<i></i></span>
<ul>
<li><a href="/doc/guide/1.0/en/form.builder">1.0</a></li>
</ul>
				</div>
				<div class="clear"></div>
			</div>
            <div class="widget-search-box">
    <form method="get" action="/search/">
        <strong>Search in this tutorial</strong>
		<input type="text" name="q" class="keyword g-text" />
        <input type="hidden" name="type" value="guide" />
        <input type="hidden" name="lang" value="en" />
        <input type="submit" value="Find" class="btn btn-info" />
	</form>
</div>
			<ul class="toc">
						    <li class="chapter"><strong>Getting Started</strong></li>
			    			        			            <li>
			                <a href="/doc/guide/1.1/en/index">Overview</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/changes">New Features</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/upgrade">Upgrading from 1.0 to 1.1</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/quickstart.what-is-yii">What is Yii</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/quickstart.installation">Installation</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/quickstart.apache-nginx-config">Apache and Nginx configurations</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/quickstart.first-app">Creating First Yii Application</a>			            </li>
			        			    						    <li class="chapter"><strong>Fundamentals</strong></li>
			    			        			            <li>
			                <a href="/doc/guide/1.1/en/basics.mvc">Model-View-Controller (MVC)</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/basics.entry">Entry Script</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/basics.application">Application</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/basics.controller">Controller</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/basics.model">Model</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/basics.view">View</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/basics.component">Component</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/basics.module">Module</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/basics.namespace">Path Alias and Namespace</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/basics.convention">Conventions</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/basics.workflow">Development Workflow</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/basics.best-practices">Best MVC Practices</a>			            </li>
			        			    						    <li class="chapter"><strong>Working with Forms</strong></li>
			    			        			            <li>
			                <a href="/doc/guide/1.1/en/form.overview">Overview</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/form.model">Creating Model</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/form.action">Creating Action</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/form.view">Creating Form</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/form.table">Collecting Tabular Input</a>			            </li>
			        			    			        			            <li class="active">
			                &raquo; Using Form Builder &laquo;
			            </li>
			        			    						    <li class="chapter"><strong>Working with Databases</strong></li>
			    			        			            <li>
			                <a href="/doc/guide/1.1/en/database.overview">Overview</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/database.dao">Database Access Objects</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/database.query-builder">Query Builder</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/database.ar">Active Record</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/database.arr">Relational Active Record</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/database.migration">Database Migration</a>			            </li>
			        			    						    <li class="chapter"><strong>Caching</strong></li>
			    			        			            <li>
			                <a href="/doc/guide/1.1/en/caching.overview">Overview</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/caching.data">Data Caching</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/caching.fragment">Fragment Caching</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/caching.page">Page Caching</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/caching.dynamic">Dynamic Content</a>			            </li>
			        			    						    <li class="chapter"><strong>Extending Yii</strong></li>
			    			        			            <li>
			                <a href="/doc/guide/1.1/en/extension.overview">Overview</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/extension.use">Using Extensions</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/extension.create">Creating Extensions</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/extension.integration">Using 3rd-Party Libraries</a>			            </li>
			        			    						    <li class="chapter"><strong>Testing</strong></li>
			    			        			            <li>
			                <a href="/doc/guide/1.1/en/test.overview">Overview</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/test.fixture">Defining Fixtures</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/test.unit">Unit Testing</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/test.functional">Functional Testing</a>			            </li>
			        			    						    <li class="chapter"><strong>Special Topics</strong></li>
			    			        			            <li>
			                <a href="/doc/guide/1.1/en/topics.gii">Automatic Code Generation</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/topics.url">URL Management</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/topics.auth">Authentication and Authorization</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/topics.theming">Theming and Skin</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/topics.logging">Logging</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/topics.error">Error Handling</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/topics.webservice">Web Service</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/topics.i18n">Internationalization (I18N)</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/topics.prado">Alternative Template Syntax</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/topics.console">Console Applications</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/topics.security">Security</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/topics.performance">Performance Tuning</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/quickstart.first-app-yiic">Code Generation using Command Line Tools (deprecated)</a>			            </li>
			        			    						</ul>
        </div>
    </div>
    <div class="grid_9 omega">
    	<div class="g-markdown"><h1 id="using-form-builder">Using Form Builder</h1>
<div class="google-ad" style="float:right;margin:0 0 1em 1em;">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-3732587985864947";
google_ad_slot = "2830391674";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<div class="toc"><ol><li><a href="#basic-concepts">Basic Concepts</a></li>
<li><a href="#creating-a-simple-form">Creating a Simple Form</a></li>
<li><a href="#specifying-form-elements">Specifying Form Elements</a></li>
<li><a href="#accessing-form-elements">Accessing Form Elements</a></li>
<li><a href="#creating-a-nested-form">Creating a Nested Form</a></li>
<li><a href="#customizing-form-display">Customizing Form Display</a></li></ol></div>


<p>When creating HTML forms, we often find that we are writing a lot of repetitive view code
which is difficult to be reused in a different project. For example, for every
input field, we need to associate it with a text label and display possible validation errors.
To improve the reusability of these code, we can use the form builder feature.</p>

<h2 id="basic-concepts">1. Basic Concepts <a class="anchor" href="#basic-concepts">¶</a></h2>

<p>The Yii form builder uses a <a href="/doc/api/1.1/CForm">CForm</a> object to represent the specifications needed to describe
an HTML form, including which data models are associated with the form,
what kind of input fields there are in the form, and how to render the whole form. Developers mainly
need to create and configure this <a href="/doc/api/1.1/CForm">CForm</a> object, and then call its rendering method to display
the form.</p>

<p>Form input specifications are organized in terms of a form element hierarchy.
At the root of the hierarchy, it is the <a href="/doc/api/1.1/CForm">CForm</a> object. The root form object maintains
its children in two collections: <a href="/doc/api/1.1/CForm#buttons">CForm::buttons</a> and <a href="/doc/api/1.1/CForm#elements">CForm::elements</a>. The former
contains the button elements (such as submit buttons, reset buttons), while the latter
contains the input elements, static text and sub-forms. A sub-form is a <a href="/doc/api/1.1/CForm">CForm</a> object contained
in the <a href="/doc/api/1.1/CForm#elements">CForm::elements</a> collection of another form. It can have its own data model,
<a href="/doc/api/1.1/CForm#buttons">CForm::buttons</a> and <a href="/doc/api/1.1/CForm#elements">CForm::elements</a> collections.</p>

<p>When users submit a form, the data entered into the input fields of the whole form hierarchy are submitted,
including those input fields that belong to the sub-forms. <a href="/doc/api/1.1/CForm">CForm</a> provides convenient methods
that can automatically assign the input data to the corresponding model attributes and perform
data validation.</p>

<h2 id="creating-a-simple-form">2. Creating a Simple Form <a class="anchor" href="#creating-a-simple-form">¶</a></h2>

<p>In the following, we show how to use the form builder to create a login form.</p>

<p>First, we write the login action code:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">actionLogin</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
<span class="hl-brackets">{</span>
    <span class="hl-var">$model</span><span class="hl-code"> = </span><span class="hl-reserved">new</span> <span class="hl-identifier">LoginForm</span><span class="hl-code">;
    </span><span class="hl-var">$form</span><span class="hl-code"> = </span><span class="hl-reserved">new</span> <span class="hl-identifier">CForm</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">application.views.site.loginForm</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-var">$model</span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-reserved">if</span><span class="hl-brackets">(</span><span class="hl-var">$form</span><span class="hl-code">-&gt;</span><span class="hl-identifier">submitted</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">login</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code"> &amp;&amp; </span><span class="hl-var">$form</span><span class="hl-code">-&gt;</span><span class="hl-identifier">validate</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span>
        <span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">redirect</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">site/index</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-reserved">else</span>
        <span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">render</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">login</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">form</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-var">$form</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;
</span><span class="hl-brackets">}</span></pre></div></div>

<p>In the above code, we create a <a href="/doc/api/1.1/CForm">CForm</a> object using the specifications pointed to
by the path alias <code>application.views.site.loginForm</code> (to be explained shortly).
The <a href="/doc/api/1.1/CForm">CForm</a> object is associated with the <code>LoginForm</code> model as described in
<a href="/doc/guide/1.1/en/form.model">Creating Model</a>.</p>

<p>As the code reads, if the form is submitted and all inputs are validated without
any error, we would redirect the user browser to the <code>site/index</code> page. Otherwise,
we render the <code>login</code> view with the form.</p>

<p>The path alias <code>application.views.site.loginForm</code> actually refers to the PHP file
<code>protected/views/site/loginForm.php</code>. The file should return a PHP array representing
the configuration needed by <a href="/doc/api/1.1/CForm">CForm</a>, as shown in the following:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">title</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">Please provide your login credential</span><span class="hl-quotes">'</span><span class="hl-code">,
 
    </span><span class="hl-quotes">'</span><span class="hl-string">elements</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">username</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">text</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">maxlength</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-number">32</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-quotes">'</span><span class="hl-string">password</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">password</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">maxlength</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-number">32</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-quotes">'</span><span class="hl-string">rememberMe</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">checkbox</span><span class="hl-quotes">'</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span>
    <span class="hl-brackets">)</span><span class="hl-code">,
 
    </span><span class="hl-quotes">'</span><span class="hl-string">buttons</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">login</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">submit</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">label</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">Login</span><span class="hl-quotes">'</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>The configuration is an associative array consisting of name-value pairs that are
used to initialize the corresponding properties of <a href="/doc/api/1.1/CForm">CForm</a>. The most important properties
to configure, as we aformentioned, are <a href="/doc/api/1.1/CForm#elements">CForm::elements</a> and <a href="/doc/api/1.1/CForm#buttons">CForm::buttons</a>. Each
of them takes an array specifying a list of form elements. We will give more details on
how to configure form elements in the next sub-section.</p>

<p>Finally, we write the <code>login</code> view script, which can be as simple as follows,</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-code">&lt;</span><span class="hl-identifier">h1</span><span class="hl-code">&gt;</span><span class="hl-identifier">Login</span><span class="hl-code">&lt;/</span><span class="hl-identifier">h1</span><span class="hl-code">&gt;
 
&lt;</span><span class="hl-identifier">div</span> <span class="hl-reserved">class</span><span class="hl-code">=</span><span class="hl-quotes">&quot;</span><span class="hl-string">form</span><span class="hl-quotes">&quot;</span><span class="hl-code">&gt;
&lt;?</span><span class="hl-identifier">php</span> <span class="hl-reserved">echo</span> <span class="hl-var">$form</span><span class="hl-code">; </span><span class="hl-inlinetags">?&gt;</span><span class="hl-code">
&lt;/</span><span class="hl-identifier">div</span><span class="hl-code">&gt;</span></pre></div></div>

<blockquote class="tip">
<p><strong>Tip:</strong> The above code <code>echo $form;</code> is equivalent to <code>echo $form-&gt;render();</code>.
  This is because <a href="/doc/api/1.1/CForm">CForm</a> implements <code>__toString</code> magic method which calls
  <code>render()</code> and returns its result as the string representation of the form object.</p>
</blockquote>

<h2 id="specifying-form-elements">3. Specifying Form Elements <a class="anchor" href="#specifying-form-elements">¶</a></h2>

<p>Using the form builder, the majority of our effort is shifted from writing view script code
to specifying the form elements. In this sub-section, we describe how to specify the <a href="/doc/api/1.1/CForm#elements">CForm::elements</a>
property. We are not going to describe <a href="/doc/api/1.1/CForm#buttons">CForm::buttons</a> because its configuration is nearly
the same as <a href="/doc/api/1.1/CForm#elements">CForm::elements</a>.</p>

<p>The <a href="/doc/api/1.1/CForm#elements">CForm::elements</a> property accepts an array as its value. Each array element specifies a single
form element which can be an input element, a static text string or a sub-form.</p>

<h3 id="specifying-input-element">Specifying Input Element</h3>

<p>An input element mainly consists of a label, an input field, a hint text and an error display.
It must be associated with a model attribute. The specification for an input element is represented
as a <a href="/doc/api/1.1/CFormInputElement">CFormInputElement</a> instance. The following code in the <a href="/doc/api/1.1/CForm#elements">CForm::elements</a> array
specifies a single input element:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-quotes">'</span><span class="hl-string">username</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">text</span><span class="hl-quotes">'</span><span class="hl-code">,
    </span><span class="hl-quotes">'</span><span class="hl-string">maxlength</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-number">32</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-code">,</span></pre></div></div>

<p>It states that the model attribute is named as <code>username</code>, and the input field type is <code>text</code> whose
<code>maxlength</code> attribute is 32.</p>

<p>Any writable property of <a href="/doc/api/1.1/CFormInputElement">CFormInputElement</a> can be configured like above. For example, we may specify
the <a href="/doc/api/1.1/CFormInputElement#hint">hint</a> option in order to display a hint text, or we may specify the
<a href="/doc/api/1.1/CFormInputElement#items">items</a> option if the input field is a list box, a drop-down list, a check-box list
or a radio-button list. If an option name is not a property of <a href="/doc/api/1.1/CFormInputElement">CFormInputElement</a>, it will be treated
the attribute of the corresponding HTML input element. For example, because <code>maxlength</code> in the above is not
a property of <a href="/doc/api/1.1/CFormInputElement">CFormInputElement</a>, it will be rendered as the <code>maxlength</code> attribute of the HTML text input field.</p>

<p>The <a href="/doc/api/1.1/CFormInputElement#type">type</a> option deserves additional attention. It specifies the type of the input
field to be rendered. For example, the <code>text</code> type means a normal text input field should be rendered;
the <code>password</code> type means a password input field should be rendered. <a href="/doc/api/1.1/CFormInputElement">CFormInputElement</a> recognizes the following
built-in types:</p>

<ul>
<li>text</li>
<li>hidden</li>
<li>password</li>
<li>textarea</li>
<li>file</li>
<li>radio</li>
<li>checkbox</li>
<li>listbox</li>
<li>dropdownlist</li>
<li>checkboxlist</li>
<li>radiolist</li>
</ul>

<p>Among the above built-in types, we would like to describe a bit more about the usage of those "list" types,
which include <code>dropdownlist</code>, <code>checkboxlist</code> and <code>radiolist</code>. These types require setting the <a href="/doc/api/1.1/CFormInputElement#items">items</a>
property of the corresponding input element. One can do so like the following:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-quotes">'</span><span class="hl-string">gender</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">dropdownlist</span><span class="hl-quotes">'</span><span class="hl-code">,
    </span><span class="hl-quotes">'</span><span class="hl-string">items</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-identifier">User</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">getGenderOptions</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-quotes">'</span><span class="hl-string">prompt</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">Please select:</span><span class="hl-quotes">'</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-code">,
 
...
 
</span><span class="hl-reserved">class</span> <span class="hl-identifier">User</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span>
    <span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">getGenderOptions</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-number">0</span><span class="hl-code"> =&gt; </span><span class="hl-quotes">'</span><span class="hl-string">Male</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-number">1</span><span class="hl-code"> =&gt; </span><span class="hl-quotes">'</span><span class="hl-string">Female</span><span class="hl-quotes">'</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span></pre></div></div>

<p>The above code will generate a drop-down list selector with prompt text "please select:". The selector options
include "Male" and "Female", which are returned by the <code>getGenderOptions</code> method in the <code>User</code> model class.</p>

<p>Besides these built-in types, the <a href="/doc/api/1.1/CFormInputElement#type">type</a> option can also take a widget class name
or the path alias to it. The widget class must extend from <a href="/doc/api/1.1/CInputWidget">CInputWidget</a> or <a href="/doc/api/1.1/CJuiInputWidget">CJuiInputWidget</a>. When rendering the input element,
an instance of the specified widget class will be created and rendered. The widget will be configured using
the specification as given for the input element.</p>

<h3 id="specifying-static-text">Specifying Static Text</h3>

<p>In many cases, a form may contain some decorational HTML code besides the input fields. For example, a horizontal
line may be needed to separate different portions of the form; an image may be needed at certain places to
enhance the visual appearance of the form. We may specify these HTML code as static text in the <a href="/doc/api/1.1/CForm#elements">CForm::elements</a>
collection. To do so, we simply specify a static text string as an array element in the appropriate position in
<a href="/doc/api/1.1/CForm#elements">CForm::elements</a>. For example,</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">elements</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-code">
        ......
        </span><span class="hl-quotes">'</span><span class="hl-string">password</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">password</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">maxlength</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-number">32</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">,
 
        </span><span class="hl-quotes">'</span><span class="hl-string">&lt;hr /&gt;</span><span class="hl-quotes">'</span><span class="hl-code">,
 
        </span><span class="hl-quotes">'</span><span class="hl-string">rememberMe</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">checkbox</span><span class="hl-quotes">'</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span>
    <span class="hl-brackets">)</span><span class="hl-code">,
    ......
</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>In the above, we insert a horizontal line between the <code>password</code> input and the <code>rememberMe</code> input.</p>

<p>Static text is best used when the text content and their position are irregular. If each input element
in a form needs to be decorated similarly, we should customize the form rendering approach, as to be explained
shortly in this section.</p>

<h3 id="specifying-sub-form">Specifying Sub-form</h3>

<p>Sub-forms are used to divide a lengthy form into several logically connected portions. For example,
we may divide user registration form into two sub-forms: login information and profile information.
Each sub-form may or may not be associated with a data model. In the user registration form example,
if we store user login information and profile information in two separate database tables (and thus
two data models), then each sub-form would be associated with a corresponding data model. If we store
everything in a single database table, then neither sub-form has a data model because they share the
same model with the root form.</p>

<p>A sub-form is also represented as a <a href="/doc/api/1.1/CForm">CForm</a> object. In order to specify a sub-form, we should configure
the <a href="/doc/api/1.1/CForm#elements">CForm::elements</a> property with an element whose type is <code>form</code>:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">elements</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-code">
        ......
        </span><span class="hl-quotes">'</span><span class="hl-string">user</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">form</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">title</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">Login Credential</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">elements</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                <span class="hl-quotes">'</span><span class="hl-string">username</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                    <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">text</span><span class="hl-quotes">'</span><span class="hl-code">,
                </span><span class="hl-brackets">)</span><span class="hl-code">,
                </span><span class="hl-quotes">'</span><span class="hl-string">password</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                    <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">password</span><span class="hl-quotes">'</span><span class="hl-code">,
                </span><span class="hl-brackets">)</span><span class="hl-code">,
                </span><span class="hl-quotes">'</span><span class="hl-string">email</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                    <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">text</span><span class="hl-quotes">'</span><span class="hl-code">,
                </span><span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">,
 
        </span><span class="hl-quotes">'</span><span class="hl-string">profile</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">form</span><span class="hl-quotes">'</span><span class="hl-code">,
            ......
        </span><span class="hl-brackets">)</span><span class="hl-code">,
        ......
    </span><span class="hl-brackets">)</span><span class="hl-code">,
    ......
</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>Like configuring a root form, we mainly need to specify the <a href="/doc/api/1.1/CForm#elements">CForm::elements</a> property for a sub-form.
If a sub-form needs to be associated with a data model, we can configure its <a href="/doc/api/1.1/CForm#model">CForm::model</a> property as well.</p>

<p>Sometimes, we may want to represent a form using a class other than the default <a href="/doc/api/1.1/CForm">CForm</a>. For example,
as will show shortly in this section, we may extend <a href="/doc/api/1.1/CForm">CForm</a> to customize the form rendering logic.
By specifying the input element type to be <code>form</code>, a sub-form will automatically be represented as an object
whose class is the same as its parent form. If we specify the input element type to be something like
<code>XyzForm</code> (a string terminated with <code>Form</code>), then the sub-form will be represented as a <code>XyzForm</code> object.</p>

<h2 id="accessing-form-elements">4. Accessing Form Elements <a class="anchor" href="#accessing-form-elements">¶</a></h2>

<p>Accessing form elements is as simple as accessing array elements. The <a href="/doc/api/1.1/CForm#elements">CForm::elements</a> property returns
a <a href="/doc/api/1.1/CFormElementCollection">CFormElementCollection</a> object, which extends from <a href="/doc/api/1.1/CMap">CMap</a> and allows accessing its elements like a normal
array. For example, in order to access the <code>username</code> element in the login form example, we can use the following
code:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$username</span><span class="hl-code"> = </span><span class="hl-var">$form</span><span class="hl-code">-&gt;</span><span class="hl-identifier">elements</span><span class="hl-brackets">[</span><span class="hl-quotes">'</span><span class="hl-string">username</span><span class="hl-quotes">'</span><span class="hl-brackets">]</span><span class="hl-code">;</span></pre></div></div>

<p>And to access the <code>email</code> element in the user registration form example, we can use</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$email</span><span class="hl-code"> = </span><span class="hl-var">$form</span><span class="hl-code">-&gt;</span><span class="hl-identifier">elements</span><span class="hl-brackets">[</span><span class="hl-quotes">'</span><span class="hl-string">user</span><span class="hl-quotes">'</span><span class="hl-brackets">]</span><span class="hl-code">-&gt;</span><span class="hl-identifier">elements</span><span class="hl-brackets">[</span><span class="hl-quotes">'</span><span class="hl-string">email</span><span class="hl-quotes">'</span><span class="hl-brackets">]</span><span class="hl-code">;</span></pre></div></div>

<p>Because <a href="/doc/api/1.1/CForm">CForm</a> implements array access for its <a href="/doc/api/1.1/CForm#elements">CForm::elements</a> property, the above code can be further
simplified as:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$username</span><span class="hl-code"> = </span><span class="hl-var">$form</span><span class="hl-brackets">[</span><span class="hl-quotes">'</span><span class="hl-string">username</span><span class="hl-quotes">'</span><span class="hl-brackets">]</span><span class="hl-code">;
</span><span class="hl-var">$email</span><span class="hl-code"> = </span><span class="hl-var">$form</span><span class="hl-brackets">[</span><span class="hl-quotes">'</span><span class="hl-string">user</span><span class="hl-quotes">'</span><span class="hl-brackets">]</span><span class="hl-brackets">[</span><span class="hl-quotes">'</span><span class="hl-string">email</span><span class="hl-quotes">'</span><span class="hl-brackets">]</span><span class="hl-code">;</span></pre></div></div>

<h2 id="creating-a-nested-form">5. Creating a Nested Form <a class="anchor" href="#creating-a-nested-form">¶</a></h2>

<p>We already described sub-forms. We call a form with sub-forms a nested form. In this section,
we use the user registration form as an example to show how to create a nested form associated
with multiple data models. We assume the user credential information is stored as a <code>User</code> model,
while the user profile information is stored as a <code>Profile</code> model.</p>

<p>We first create the <code>register</code> action as follows:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">actionRegister</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
<span class="hl-brackets">{</span>
    <span class="hl-var">$form</span><span class="hl-code"> = </span><span class="hl-reserved">new</span> <span class="hl-identifier">CForm</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">application.views.user.registerForm</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-var">$form</span><span class="hl-brackets">[</span><span class="hl-quotes">'</span><span class="hl-string">user</span><span class="hl-quotes">'</span><span class="hl-brackets">]</span><span class="hl-code">-&gt;</span><span class="hl-identifier">model</span><span class="hl-code"> = </span><span class="hl-reserved">new</span> <span class="hl-identifier">User</span><span class="hl-code">;
    </span><span class="hl-var">$form</span><span class="hl-brackets">[</span><span class="hl-quotes">'</span><span class="hl-string">profile</span><span class="hl-quotes">'</span><span class="hl-brackets">]</span><span class="hl-code">-&gt;</span><span class="hl-identifier">model</span><span class="hl-code"> = </span><span class="hl-reserved">new</span> <span class="hl-identifier">Profile</span><span class="hl-code">;
    </span><span class="hl-reserved">if</span><span class="hl-brackets">(</span><span class="hl-var">$form</span><span class="hl-code">-&gt;</span><span class="hl-identifier">submitted</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">register</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code"> &amp;&amp; </span><span class="hl-var">$form</span><span class="hl-code">-&gt;</span><span class="hl-identifier">validate</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-var">$user</span><span class="hl-code"> = </span><span class="hl-var">$form</span><span class="hl-brackets">[</span><span class="hl-quotes">'</span><span class="hl-string">user</span><span class="hl-quotes">'</span><span class="hl-brackets">]</span><span class="hl-code">-&gt;</span><span class="hl-identifier">model</span><span class="hl-code">;
        </span><span class="hl-var">$profile</span><span class="hl-code"> = </span><span class="hl-var">$form</span><span class="hl-brackets">[</span><span class="hl-quotes">'</span><span class="hl-string">profile</span><span class="hl-quotes">'</span><span class="hl-brackets">]</span><span class="hl-code">-&gt;</span><span class="hl-identifier">model</span><span class="hl-code">;
        </span><span class="hl-reserved">if</span><span class="hl-brackets">(</span><span class="hl-var">$user</span><span class="hl-code">-&gt;</span><span class="hl-identifier">save</span><span class="hl-brackets">(</span><span class="hl-reserved">false</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span>
        <span class="hl-brackets">{</span>
            <span class="hl-var">$profile</span><span class="hl-code">-&gt;</span><span class="hl-identifier">userID</span><span class="hl-code"> = </span><span class="hl-var">$user</span><span class="hl-code">-&gt;</span><span class="hl-identifier">id</span><span class="hl-code">;
            </span><span class="hl-var">$profile</span><span class="hl-code">-&gt;</span><span class="hl-identifier">save</span><span class="hl-brackets">(</span><span class="hl-reserved">false</span><span class="hl-brackets">)</span><span class="hl-code">;
            </span><span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">redirect</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">site/index</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;
        </span><span class="hl-brackets">}</span>
    <span class="hl-brackets">}</span>
 
    <span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">render</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">register</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">form</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-var">$form</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;
</span><span class="hl-brackets">}</span></pre></div></div>

<p>In the above, we create the form using the configuration specified by <code>application.views.user.registerForm</code>.
After the form is submitted and validated successfully, we attempt to save the user and profile models.
We retrieve the user and profile models by accessing the <code>model</code> property of the corresponding sub-form objects.
Because the input validation is already done, we call <code>$user-&gt;save(false)</code> to skip the validation. We do
this similarly for the profile model.</p>

<p>Next, we write the form configuration file <code>protected/views/user/registerForm.php</code>:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">elements</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">user</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">form</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">title</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">Login information</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">elements</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                <span class="hl-quotes">'</span><span class="hl-string">username</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                    <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">text</span><span class="hl-quotes">'</span><span class="hl-code">,
                </span><span class="hl-brackets">)</span><span class="hl-code">,
                </span><span class="hl-quotes">'</span><span class="hl-string">password</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                    <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">password</span><span class="hl-quotes">'</span><span class="hl-code">,
                </span><span class="hl-brackets">)</span><span class="hl-code">,
                </span><span class="hl-quotes">'</span><span class="hl-string">email</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                    <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">text</span><span class="hl-quotes">'</span><span class="hl-code">,
                </span><span class="hl-brackets">)</span>
            <span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">,
 
        </span><span class="hl-quotes">'</span><span class="hl-string">profile</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">form</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">title</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">Profile information</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">elements</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                <span class="hl-quotes">'</span><span class="hl-string">firstName</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                    <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">text</span><span class="hl-quotes">'</span><span class="hl-code">,
                </span><span class="hl-brackets">)</span><span class="hl-code">,
                </span><span class="hl-quotes">'</span><span class="hl-string">lastName</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                    <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">text</span><span class="hl-quotes">'</span><span class="hl-code">,
                </span><span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span><span class="hl-code">,
 
    </span><span class="hl-quotes">'</span><span class="hl-string">buttons</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">register</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">submit</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">label</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">Register</span><span class="hl-quotes">'</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>In the above, when specifying each sub-form, we also specify its <a href="/doc/api/1.1/CForm#title">CForm::title</a> property.
The default form rendering logic will enclose each sub-form in a field-set which uses this property
as its title.</p>

<p>Finally, we write the simple <code>register</code> view script:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-code">&lt;</span><span class="hl-identifier">h1</span><span class="hl-code">&gt;</span><span class="hl-identifier">Register</span><span class="hl-code">&lt;/</span><span class="hl-identifier">h1</span><span class="hl-code">&gt;
 
&lt;</span><span class="hl-identifier">div</span> <span class="hl-reserved">class</span><span class="hl-code">=</span><span class="hl-quotes">&quot;</span><span class="hl-string">form</span><span class="hl-quotes">&quot;</span><span class="hl-code">&gt;
&lt;?</span><span class="hl-identifier">php</span> <span class="hl-reserved">echo</span> <span class="hl-var">$form</span><span class="hl-code">; </span><span class="hl-inlinetags">?&gt;</span><span class="hl-code">
&lt;/</span><span class="hl-identifier">div</span><span class="hl-code">&gt;</span></pre></div></div>

<h2 id="customizing-form-display">6. Customizing Form Display <a class="anchor" href="#customizing-form-display">¶</a></h2>

<p>The main benefit of using form builder is the separation of logic (form configuration stored in a separate file)
and presentation (<a href="/doc/api/1.1/CForm#render">CForm::render</a> method). As a result, we can customize the form display by either overriding
<a href="/doc/api/1.1/CForm#render">CForm::render</a> or providing a partial view to render the form. Both approaches can keep the form configuration
intact and can be reused easily.</p>

<p>When overriding <a href="/doc/api/1.1/CForm#render">CForm::render</a>, one mainly needs to traverse through the <a href="/doc/api/1.1/CForm#elements">CForm::elements</a> and <a href="/doc/api/1.1/CForm#buttons">CForm::buttons</a>
collections and call the <a href="/doc/api/1.1/CFormElement#render">CFormElement::render</a> method of each form element. For example,</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">class</span> <span class="hl-identifier">MyForm</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CForm</span>
<span class="hl-brackets">{</span>
    <span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">render</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-var">$output</span><span class="hl-code"> = </span><span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">renderBegin</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;
 
        </span><span class="hl-reserved">foreach</span><span class="hl-brackets">(</span><span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">getElements</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span> <span class="hl-reserved">as</span> <span class="hl-var">$element</span><span class="hl-brackets">)</span>
            <span class="hl-var">$output</span><span class="hl-code"> .= </span><span class="hl-var">$element</span><span class="hl-code">-&gt;</span><span class="hl-identifier">render</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;
 
        </span><span class="hl-var">$output</span><span class="hl-code"> .= </span><span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">renderEnd</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;
 
        </span><span class="hl-reserved">return</span> <span class="hl-var">$output</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span></pre></div></div>

<p>We may also write a view script <code>_form</code> to render a form:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-inlinetags">&lt;?php</span>
<span class="hl-reserved">echo</span> <span class="hl-var">$form</span><span class="hl-code">-&gt;</span><span class="hl-identifier">renderBegin</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;
 
</span><span class="hl-reserved">foreach</span><span class="hl-brackets">(</span><span class="hl-var">$form</span><span class="hl-code">-&gt;</span><span class="hl-identifier">getElements</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span> <span class="hl-reserved">as</span> <span class="hl-var">$element</span><span class="hl-brackets">)</span>
    <span class="hl-reserved">echo</span> <span class="hl-var">$element</span><span class="hl-code">-&gt;</span><span class="hl-identifier">render</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;
 
</span><span class="hl-reserved">echo</span> <span class="hl-var">$form</span><span class="hl-code">-&gt;</span><span class="hl-identifier">renderEnd</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>To use this view script, we can simply call:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-code">&lt;</span><span class="hl-identifier">div</span> <span class="hl-reserved">class</span><span class="hl-code">=</span><span class="hl-quotes">&quot;</span><span class="hl-string">form</span><span class="hl-quotes">&quot;</span><span class="hl-code">&gt;
&lt;?</span><span class="hl-identifier">php</span> <span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">renderPartial</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">_form</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">form</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-var">$form</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">; </span><span class="hl-inlinetags">?&gt;</span><span class="hl-code">
&lt;/</span><span class="hl-identifier">div</span><span class="hl-code">&gt;</span></pre></div></div>

<p>If a generic form rendering does not work for a particular form (for example, the form needs some
irregular decorations for certain elements), we can do like the following in a view script:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-identifier">some</span> <span class="hl-identifier">complex</span> <span class="hl-identifier">UI</span> <span class="hl-identifier">elements</span> <span class="hl-identifier">here</span><span class="hl-code">
 
&lt;?</span><span class="hl-identifier">php</span> <span class="hl-reserved">echo</span> <span class="hl-var">$form</span><span class="hl-brackets">[</span><span class="hl-quotes">'</span><span class="hl-string">username</span><span class="hl-quotes">'</span><span class="hl-brackets">]</span><span class="hl-code">; </span><span class="hl-inlinetags">?&gt;</span>
 
<span class="hl-identifier">some</span> <span class="hl-identifier">complex</span> <span class="hl-identifier">UI</span> <span class="hl-identifier">elements</span> <span class="hl-identifier">here</span><span class="hl-code">
 
&lt;?</span><span class="hl-identifier">php</span> <span class="hl-reserved">echo</span> <span class="hl-var">$form</span><span class="hl-brackets">[</span><span class="hl-quotes">'</span><span class="hl-string">password</span><span class="hl-quotes">'</span><span class="hl-brackets">]</span><span class="hl-code">; </span><span class="hl-inlinetags">?&gt;</span>
 
<span class="hl-identifier">some</span> <span class="hl-identifier">complex</span> <span class="hl-identifier">UI</span> <span class="hl-identifier">elements</span> <span class="hl-identifier">here</span></pre></div></div>

<p>In the last approach, the form builder seems not to bring us much benefit, as we still need to write
similar amount of form code. It is still beneficial, however, that the form is specified using
a separate configuration file as it helps developers to better focus on the logic.</p>

<div class="revision"><div class="google-ad" style="margin:-60px 0 5px 200px;">
<script type="text/javascript"><!--
google_ad_client = "ca-pub-3732587985864947";
google_ad_slot = "7116172008";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>$Id$</div>
</div>
                <div class="prev-next-nav">
                            <div class="prev-topic"><a href="/doc/guide/1.1/en/form.table">Collecting Tabular Input</a></div>
                                        <div class="next-topic"><a href="/doc/guide/1.1/en/database.overview">Overview</a></div>
                    </div>
        
		        <div class="widget-comment-list" id="comments">
	<div class="comments">
		<h3>Total 7 comments</h3>
				<div class="comment alt-0">
			<a class="cid" id="c6092" title="permalink to this comment" href="#c6092">#6092</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=6092"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=6092&amp;vote=1"><span>1</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=6092&amp;vote=0"><span>1</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/13362/">Farzan</a> at 2011/12/12 12:30am</div>
			<div class="title">Stateful form</div>
			<div class="content"><p>If you want to create a <em>stateful</em> form, change the config file as below:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">activeForm</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">stateful</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">true</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span><span class="hl-code">,
    ...
</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>
</div>
					</div>
				<div class="comment alt-1">
			<a class="cid" id="c5080" title="permalink to this comment" href="#c5080">#5080</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=5080"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=5080&amp;vote=1"><span>6</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=5080&amp;vote=0"><span>1</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/6867/">Say_Ten</a> at 2011/09/13 10:39am</div>
			<div class="title">Re: #472</div>
			<div class="content"><p>I just discovered, and it makes sense, but in the form config file you're in the context of the CForm object.  This enables you to use $this in the file, such as:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">elements</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">attribute</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-quotes">'</span><span class="hl-string">dropdownlist</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">items</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">model</span><span class="hl-code">-&gt;</span><span class="hl-identifier">getAttributeListData</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>
</div>
					</div>
				<div class="comment alt-0">
			<a class="cid" id="c5004" title="permalink to this comment" href="#c5004">#5004</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=5004"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=5004&amp;vote=1"><span>2</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=5004&amp;vote=0"><span>2</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/10821/">pligor</a> at 2011/09/05 10:29am</div>
			<div class="title">how to render these complex UI elements</div>
			<div class="content"><p>If you want to do a custom rendering of an element then you could take each of its properties and render it.
I mean use the</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$form</span><span class="hl-brackets">[</span><span class="hl-quotes">'</span><span class="hl-string">attribute</span><span class="hl-quotes">'</span><span class="hl-brackets">]</span><span class="hl-code">-&gt;</span><span class="hl-identifier">label</span></pre></div></div>

<p>for label along with CHtml static methods and so on.</p>

<p>The best approach would be to create a widget which has the CInputWidget as its parent class.</p>

<p>Now if you are too lazy to implement a new widget you could try this:
Use the "layout" attribute</p>

<p>By default:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-identifier">layout</span><span class="hl-code"> = </span><span class="hl-quotes">'</span><span class="hl-string">{label} {input} {hint} {error}</span><span class="hl-quotes">'</span></pre></div></div>

<p>So you can create,for example, a custom input, get its returned html code
and redefine the layout as such:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$input</span><span class="hl-code"> = </span><span class="hl-identifier">some_render_input_method_or_function</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;
</span><span class="hl-identifier">layout</span><span class="hl-code"> = </span><span class="hl-quotes">'</span><span class="hl-string">{label} </span><span class="hl-quotes">'</span><span class="hl-code">. </span><span class="hl-var">$input</span><span class="hl-code"> .</span><span class="hl-quotes">'</span><span class="hl-string"> {hint} {error}</span><span class="hl-quotes">'</span><span class="hl-code">;</span></pre></div></div>

<p>That's it, now you have the Ugly, The Beautiful and the Lazy to choose on how to render ;)</p>
</div>
					</div>
				<div class="comment alt-1">
			<a class="cid" id="c2752" title="permalink to this comment" href="#c2752">#2752</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=2752"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=2752&amp;vote=1"><span>4</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=2752&amp;vote=0"><span>1</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/3518/">rAWTAZ</a> at 2011/02/05 04:16pm</div>
			<div class="title">Attributes must be safe</div>
			<div class="content"><p>In Yii 1.1.6, and probably earlier versions as well, the attribute name that the element key defines must be a "safe" attribute in the model. If it is not considered safe, it will not be rendered. At least when you use a widget like this in the 'elements' array:</p>

<p>'attributeName'=&gt;array(
    'type'=&gt;'MyWidget',
),</p>

<p>When implementing a custom widget that didn't map to a particular attribute (i.e. I had no use of specifying an attribute name, but had to since a key is required), I noticed that unless the virtual attribute name I used didn't have a rule that made it "safe" in the model, the widget wouldnt be rendered at all.</p>

<p>Actually it seems that there being a rule for the attribute is the only requirement for its element to be rendered; I didn't have to define the attribute even virtually.</p>

<p>See <a href="http://www.yiiframework.com/doc/guide/en/form.model#securing-attribute-assignments" title="Securing Attribute Assignments">Securing Attribute Assignments</a> in the Yii Guide for more information on "safe" attributes.</p>
</div>
					</div>
				<div class="comment alt-0">
			<a class="cid" id="c472" title="permalink to this comment" href="#c472">#472</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=472"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=472&amp;vote=1"><span>2</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=472&amp;vote=0"><span>1</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/46/">KJedi</a> at 2010/05/21 06:54am</div>
			<div class="title">data from the model in the dropdown</div>
			<div class="content"><p>It becomes tricky when you want to use data from the model in dropdown when using CForm. Sure, you can create config array in the Controller, but the cleaner way is to do it in view as shown this article. I used the following method for this:
--registerForm.php--</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-inlinetags">&lt;?php</span>
<span class="hl-var">$data</span><span class="hl-code"> = </span><span class="hl-identifier">CHtml</span><span class="hl-code">::</span><span class="hl-identifier">listData</span><span class="hl-brackets">(</span><span class="hl-identifier">User</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">userID</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">username</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">);
</span><span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-code"> 
....
</span><span class="hl-quotes">'</span><span class="hl-string">users</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
<span class="hl-quotes">'</span><span class="hl-string">type</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">dropdownlist</span><span class="hl-quotes">'</span><span class="hl-code">,
</span><span class="hl-quotes">'</span><span class="hl-string">items</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-var">$data</span><span class="hl-comment">//</span><span class="hl-comment">here it goes</span>
<span class="hl-brackets">)</span><span class="hl-code">,
...
</span><span class="hl-brackets">)</span></pre></div></div>
</div>
					</div>
				<div class="comment alt-1">
			<a class="cid" id="c721" title="permalink to this comment" href="#c721">#721</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=721"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=721&amp;vote=1"><span>6</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=721&amp;vote=0"><span>0</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/2049/">ptoly</a> at 2010/03/11 02:32pm</div>
			<div class="title">How to generate multi select elements (dropdownlists, etc)</div>
			<div class="content"><p>It took me a while to figure this out and some educated guesses as there seems to be no documentation on it. The key is the <em>items</em> array gets turned into a options/values. I hope this helps someone!</p>

<pre>$form = new CForm(
array(
    'title' =&gt;'form title',
        'showErrorSummary'  =&gt; true,
        'elements'          =&gt; array(
            'numCols' =&gt; array(
                'type' =&gt; 'dropdownlist', 
                'items' =&gt; array(1=&gt;1,2=&gt;2,3=&gt;3,4=&gt;4),
                ),
            'numRows' =&gt; array(
                'type' =&gt; 'dropdownlist', 
                'items' =&gt; array(2=&gt;2,3=&gt;3,4=&gt;4,5=&gt;5),
                ),
            'defaultStatus' =&gt; array(
                'type' =&gt; 'text', 
                'maxlength' =&gt; 24,
                ),
        ),
        'buttons'=&gt;array(
            'submit'=&gt;array(
                'type'=&gt;'submit',
                'label'=&gt;'Save',
        ),
    ),
),
$model
);</pre>
</div>
					</div>
				<div class="comment alt-0">
			<a class="cid" id="c741" title="permalink to this comment" href="#c741">#741</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=741"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=741&amp;vote=1"><span>12</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=741&amp;vote=0"><span>0</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/4233/">ciss</a> at 2010/03/08 07:53am</div>
			<div class="title">Avoid &quot;echo $form;&quot;</div>
			<div class="content"><p>Using "echo $form" will give you a hard time tracing errors in your form configuration, since an exception thrown in CForm::__toString() doesn't get caught this way.
<strong>Use $form-&gt;render() instead</strong> to have the benefit of a complete stack trace.</p>
</div>
					</div>
			</div>
	<div id="comment-add">
		<h3 id="add-comment">Leave a comment</h3>

			<p>Please <a class="g-login" rel="/doc/guide/1.1/en/form.builder#add-comment" href="#">login</a> to leave your comment.</p>
		</div>
</div>
           </div>
</div>
					</div>
				
								<div class="clear"></div>
			</div>
			<div class="clear"></div>
					</div>
	</div>

	<div class="layout-main-footer">
		<div class="container_12">
			<div class="grid_6">
				<ul class="menu">
				<li class="main">About
<ul class="sub">
<li><a href="/about/">About Yii</a></li>
<li><a href="/features/">Features</a></li>
<li><a href="/performance/">Performance</a></li>
<li><a href="/license/">License</a></li>
<li><a href="/contact/">Contact Us</a></li>
</ul>
</li>
<li class="main">Downloads
<ul class="sub">
<li><a href="/download/">Framework</a></li>
<li><a href="/extensions/">Extensions</a></li>
<li><a href="/demos/">Demos</a></li>
<li><a href="/logo/">Logo</a></li>
</ul>
</li>
<li class="main">Documentation
<ul class="sub">
<li><a href="/tour/">Take the Tour</a></li>
<li><a href="/tutorials/">Tutorials</a></li>
<li><a href="/doc/api/">Class Reference</a></li>
<li><a href="/doc-2.0/guide-index.html">Guide 2.0</a></li>
<li><a href="/doc-2.0/index.html">Class Reference 2.0</a></li>
<li><a href="/wiki/">Wiki</a></li>
<li><a href="/screencasts/">Screencasts</a></li>
<li><a href="/resources/">Resources</a></li>
</ul>
</li>
<li class="main">Development
<ul class="sub">
<li><a href="/contribute/">Contribute to Yii</a></li>
<li><a href="https://github.com/yiisoft/yii/commits/master">Latest Updates</a></li>
<li><a href="https://github.com/yiisoft/yii/issues/new">Report a Bug</a></li>
<li><a href="/security/">Report a Security Issue</a></li>
</ul>
</li>
<li class="main">Community
<ul class="sub">
<li><a href="/forum/">Forum</a></li>
<li><a href="/chat/">Live Chat</a></li>
<li><a href="/news/">News</a></li>
<li><a href="/user/halloffame/">Hall of Fame</a></li>
<li><a href="/badges/">Badges</a></li>
</ul>
</li>
				</ul>
			</div>
			<div class="grid_1">&nbsp;</div>
			<div class="grid_5">
				<h3>Yii Supporters</h3>
				<ul class="g-list-none supporters">

				</ul>
			</div>

			<div class="clear"></div>
			<div class="grid_12 copyright">
				<ul class="social">
					<li class="twitter"><a href="https://twitter.com/yiiframework" target="_blank" rel="nofollow" title="follow us on twitter">Twitter</a></li>
					<li class="facebook"><a href="https://www.facebook.com/groups/yiitalk/" target="_blank" rel="nofollow" title="join yii group at facebook">Facebook</a></li>
					<li class="linkedin"><a href="http://www.linkedin.com/groups?gid=1483367" target="_blank" rel="nofollow" title="join yii group at linkedin">LinkedIn</a></li>
					<li class="feeds"><a title="RSS feeds" href="/rss.xml/">RSS Feeds</a></li>
				</ul>
				<div class="clear"></div>
				<a href="/tos/">Terms of Service</a> |
				<a href="/license/">License</a> |
				<a href="/contact/">Contact Us</a><br/>
				Copyright &copy; 2015 by <a href="http://www.yiisoft.com">Yii Software LLC</a>.
				All Rights Reserved.
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>

    <script type="text/javascript" src="/js/site-20121004195728.js"></script>


<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['site._setAccount', 'UA-5843896-1']);
_gaq.push(['site._trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
<script type="text/javascript">
function trackClick(link, action, category) {
	action=action || link.href;
	category=category || 'Outbound Links';
	try {
		_gaq.push(['site._trackEvent', category, action]);
		setTimeout('document.location = "' + link.href + '"', 250);
	}catch(err){}
	return false;
}
</script>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
</body>
</html>
