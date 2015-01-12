<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    	<meta charset="UTF-8" />
		<meta name="keywords" content="yii framework, tutorial, guide, version 1.1" />
	<meta name="description" content="We have already seen how to use Active Record (AR) to select data from a
single database table." />
    <link rel="shortcut icon" type="image/x-icon" href="http://static.yiiframework.com/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="http://static.yiiframework.com/css/site-20130404102234.css" />

	<link title="Lives News for Yii Framework" rel="alternate" type="application/rss+xml" href="http://www.yiiframework.com/rss.xml/" />
	<title>Working with Databases: Relational Active Record | The Definitive Guide to Yii | Yii PHP Framework</title>
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
<li><a href="/doc/guide/1.1/de/database.arr">Deutsch</a></li>
<li><a href="/doc/guide/1.1/es/database.arr">Español</a></li>
<li><a href="/doc/guide/1.1/fr/database.arr">Français</a></li>
<li><a href="/doc/guide/1.1/he/database.arr">עִבְרִית</a></li>
<li><a href="/doc/guide/1.1/id/database.arr">Bahasa Indonesia</a></li>
<li><a href="/doc/guide/1.1/it/database.arr">Italiano</a></li>
<li><a href="/doc/guide/1.1/ja/database.arr">日本語</a></li>
<li><a href="/doc/guide/1.1/pl/database.arr">Polski</a></li>
<li><a href="/doc/guide/1.1/pt/database.arr">Português</a></li>
<li><a href="/doc/guide/1.1/pt_br/database.arr">Português brasileiro</a></li>
<li><a href="/doc/guide/1.1/ro/database.arr">România</a></li>
<li><a href="/doc/guide/1.1/ru/database.arr">Русский</a></li>
<li><a href="/doc/guide/1.1/sv/database.arr">Svenska</a></li>
<li><a href="/doc/guide/1.1/uk/database.arr">украї́нська</a></li>
<li><a href="/doc/guide/1.1/zh_cn/database.arr">简体中文</a></li>
</ul>
	    		</div>
				<div class="versions g-dropdown">
	    		<span>1.1<i></i></span>
<ul>
<li><a href="/doc/guide/1.0/en/database.arr">1.0</a></li>
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
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/form.builder">Using Form Builder</a>			            </li>
			        			    						    <li class="chapter"><strong>Working with Databases</strong></li>
			    			        			            <li>
			                <a href="/doc/guide/1.1/en/database.overview">Overview</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/database.dao">Database Access Objects</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/database.query-builder">Query Builder</a>			            </li>
			        			    			        			            <li>
			                <a href="/doc/guide/1.1/en/database.ar">Active Record</a>			            </li>
			        			    			        			            <li class="active">
			                &raquo; Relational Active Record &laquo;
			            </li>
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
    	<div class="g-markdown"><h1 id="relational-active-record">Relational Active Record</h1>
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
<div class="toc"><ol><li><a href="#declaring-relationship">Declaring Relationship</a></li>
<li><a href="#performing-relational-query">Performing Relational Query</a></li>
<li><a href="#performing-relational-query-without-getting-related-models">Performing Relational query without getting related models</a></li>
<li><a href="#relational-query-options">Relational Query Options</a></li>
<li><a href="#disambiguating-column-names">Disambiguating Column Names</a></li>
<li><a href="#dynamic-relational-query-options">Dynamic Relational Query Options</a></li>
<li><a href="#relational-query-performance">Relational Query Performance</a></li>
<li><a href="#statistical-query">Statistical Query</a></li>
<li><a href="#relational-query-with-named-scopes">Relational Query with Named Scopes</a></li>
<li><a href="#relational-query-with-through">Relational Query with through</a></li>
<li><a href="#post-join-operations">Post-JOIN operations</a></li></ol></div>


<p>We have already seen how to use Active Record (AR) to select data from a
single database table. In this section, we describe how to use AR to join
several related database tables and bring back the joint data set.</p>

<p>In order to use relational AR, it is recommended that primary-foreign key
constraints are declared for tables that need to be joined. The constraints
will help to keep the consistency and integrity of the relational data.</p>

<p>For simplicity, we will use the database schema shown in the
following entity-relationship (ER) diagram to illustrate examples in this
section.</p>

<div class="image"><p>ER Diagram</p><img src="/tutorial/image?type=guide&amp;version=1.1&amp;lang=en&amp;file=er.png" alt="ER Diagram" /></div>

<blockquote class="info">
<p><strong>Info:</strong> Support for foreign key constraints varies in different DBMS.
  SQLite 3.6.19 or prior does not support foreign key constraints, but you can still
  declare the constraints when creating tables. MySQL’s MyISAM engine
  does not support foreign keys at all.</p>
</blockquote>

<h2 id="declaring-relationship">1. Declaring Relationship <a class="anchor" href="#declaring-relationship">¶</a></h2>

<p>Before we use AR to perform relational query, we need to let AR know how
one AR class is related with another.</p>

<p>Relationship between two AR classes is directly associated with the
relationship between the database tables represented by the AR classes.
From database point of view, a relationship between two tables A and B has
three types: one-to-many (e.g. <code>tbl_user</code> and <code>tbl_post</code>), one-to-one (e.g.
<code>tbl_user</code> and <code>tbl_profile</code>) and many-to-many (e.g. <code>tbl_category</code> and <code>tbl_post</code>).
In AR, there are four types of relationships:</p>

<ul>
<li><p><code>BELONGS_TO</code>: if the relationship between table A and B is
one-to-many, then B belongs to A (e.g. <code>Post</code> belongs to <code>User</code>);</p></li>
<li><p><code>HAS_MANY</code>: if the relationship between table A and B is one-to-many,
then A has many B (e.g. <code>User</code> has many <code>Post</code>);</p></li>
<li><p><code>HAS_ONE</code>: this is special case of <code>HAS_MANY</code> where A has at most one
B (e.g. <code>User</code> has at most one <code>Profile</code>);</p></li>
<li><p><code>MANY_MANY</code>: this corresponds to the many-to-many relationship in
database. An associative table is needed to break a many-to-many
relationship into one-to-many relationships, as most DBMS do not support
many-to-many relationship directly. In our example database schema, the
<code>tbl_post_category</code> serves for this purpose. In AR terminology, we can explain
<code>MANY_MANY</code> as the combination of <code>BELONGS_TO</code> and <code>HAS_MANY</code>. For example,
<code>Post</code> belongs to many <code>Category</code> and <code>Category</code> has many <code>Post</code>.</p></li>
</ul>

<p>There is fifth special type which performs aggregational queries on the related
records - it's called <code>STAT</code>. Please refer to the
<a href="/doc/guide/1.1/en/database.arr#statistical-query">Statistical Query</a> section
for more details.</p>

<p>Declaring relationship in AR involves overriding the
<a href="/doc/api/1.1/CActiveRecord#relations">relations()</a> method of <a href="/doc/api/1.1/CActiveRecord">CActiveRecord</a>. The
method returns an array of relationship configurations. Each array element
represents a single relationship with the following format:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-quotes">'</span><span class="hl-string">VarName</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">RelationType</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">ClassName</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">ForeignKey</span><span class="hl-quotes">'</span><span class="hl-code">, ...</span><span class="hl-identifier">additional</span> <span class="hl-identifier">options</span><span class="hl-brackets">)</span></pre></div></div>

<p>where <code>VarName</code> is the name of the relationship; <code>RelationType</code> specifies
the type of the relationship, which can be one of the four constants:
<code>self::BELONGS_TO</code>, <code>self::HAS_ONE</code>, <code>self::HAS_MANY</code> and
<code>self::MANY_MANY</code>; <code>ClassName</code> is the name of the AR class related to this
AR class; and <code>ForeignKey</code> specifies the foreign key(s) involved in the
relationship. Additional options can be specified at the end for each
relationship (to be described later).</p>

<p>The following code shows how we declare the relationships for the <code>User</code>
and <code>Post</code> classes.</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">class</span> <span class="hl-identifier">Post</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span><span class="hl-code">
    ......
 
    </span><span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">author</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">BELONGS_TO</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">User</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">author_id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">categories</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">MANY_MANY</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Category</span><span class="hl-quotes">'</span><span class="hl-code">,
                </span><span class="hl-quotes">'</span><span class="hl-string">tbl_post_category(post_id, category_id)</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span>
 
<span class="hl-reserved">class</span> <span class="hl-identifier">User</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span><span class="hl-code">
    ......
 
    </span><span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">posts</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_MANY</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Post</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">author_id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">profile</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_ONE</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Profile</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">owner_id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span></pre></div></div>

<blockquote class="info">
<p><strong>Info:</strong> A foreign key may be composite, consisting of two or more columns.
  In this case, we should concatenate the names of the foreign key columns
  and separate them with commas or an array such as <code>array('key1','key2')</code>.
  In case you need to specify custom <code>PK-&gt;FK</code> association you can define it as
  <code>array('fk'=&gt;'pk')</code>. For composite keys it will be <code>array('fk_c1'=&gt;'pk_c1','fk_c2'=&gt;'pk_c2')</code>.
  For <code>MANY_MANY</code> relationship type,
  the associative table name must also be specified in the foreign key. For
  example, the <code>categories</code> relationship in <code>Post</code> is specified with the
  foreign key <code>tbl_post_category(post_id, category_id)</code>.
  The declaration of relationships in an AR class implicitly adds a property
  to the class for each relationship. After a relational query is performed,
  the corresponding property will be populated with the related AR
  instance(s). For example, if <code>$author</code> represents a <code>User</code> AR instance,
  we can use <code>$author-&gt;posts</code> to access its related <code>Post</code> instances.</p>
</blockquote>

<h2 id="performing-relational-query">2. Performing Relational Query <a class="anchor" href="#performing-relational-query">¶</a></h2>

<p>The simplest way of performing relational query is by reading a relational
property of an AR instance. If the property is not accessed previously, a
relational query will be initiated, which joins the two related tables and
filters with the primary key of the current AR instance. The query result
will be saved to the property as instance(s) of the related AR class. This
is known as the <em>lazy loading</em> approach, i.e., the relational query
is performed only when the related objects are initially accessed. The
example below shows how to use this approach:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-comment">//</span><span class="hl-comment"> retrieve the post whose ID is 10</span>
<span class="hl-var">$post</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findByPk</span><span class="hl-brackets">(</span><span class="hl-number">10</span><span class="hl-brackets">)</span><span class="hl-code">;
</span><span class="hl-comment">//</span><span class="hl-comment"> retrieve the post's author: a relational query will be performed here</span>
<span class="hl-var">$author</span><span class="hl-code">=</span><span class="hl-var">$post</span><span class="hl-code">-&gt;</span><span class="hl-identifier">author</span><span class="hl-code">;</span></pre></div></div>

<blockquote class="info">
<p><strong>Info:</strong> If there is no related instance for a relationship, the
  corresponding property could be either null or an empty array. For
  <code>BELONGS_TO</code> and <code>HAS_ONE</code> relationships, the result is null; for
  <code>HAS_MANY</code> and <code>MANY_MANY</code>, it is an empty array.
  Note that the <code>HAS_MANY</code> and <code>MANY_MANY</code> relationships return arrays of objects,
  you will need to loop through the results before trying to access any properties.
  Otherwise, you may receive "Trying to get property of non-object" errors.</p>
</blockquote>

<p>The lazy loading approach is very convenient to use, but it is not
efficient in some scenarios. For example, if we want to access the author
information for <code>N</code> posts, using the lazy approach would involve executing
<code>N</code> join queries. We should resort to the so-called <em>eager loading</em>
approach under this circumstance.</p>

<p>The eager loading approach retrieves the related AR instances together
with the main AR instance(s). This is accomplished by using the
<a href="/doc/api/1.1/CActiveRecord#with">with()</a> method together with one of the
<a href="/doc/api/1.1/CActiveRecord#find">find</a> or <a href="/doc/api/1.1/CActiveRecord#findAll">findAll</a> methods in
AR. For example,</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">author</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>The above code will return an array of <code>Post</code> instances. Unlike the lazy
approach, the <code>author</code> property in each <code>Post</code> instance is already
populated with the related <code>User</code> instance before we access the property.
Instead of executing a join query for each post, the eager loading approach
brings back all posts together with their authors in a single join query!</p>

<p>We can specify multiple relationship names in the
<a href="/doc/api/1.1/CActiveRecord#with">with()</a> method and the eager loading approach will
bring them back all in one shot. For example, the following code will bring
back posts together with their authors and categories:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">author</span><span class="hl-quotes">'</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">categories</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>We can also do nested eager loading. Instead of a list of relationship
names, we pass in a hierarchical representation of relationship names to
the <a href="/doc/api/1.1/CActiveRecord#with">with()</a> method, like the following,</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">author.profile</span><span class="hl-quotes">'</span><span class="hl-code">,
    </span><span class="hl-quotes">'</span><span class="hl-string">author.posts</span><span class="hl-quotes">'</span><span class="hl-code">,
    </span><span class="hl-quotes">'</span><span class="hl-string">categories</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>The above example will bring back all posts together with their author and
categories. It will also bring back each author's profile and posts.</p>

<p>Eager loading may also be executed by specifying
the <a href="/doc/api/1.1/CDbCriteria#with">CDbCriteria::with</a> property, like the following:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$criteria</span><span class="hl-code">=</span><span class="hl-reserved">new</span> <span class="hl-identifier">CDbCriteria</span><span class="hl-code">;
</span><span class="hl-var">$criteria</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-code">=</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">author.profile</span><span class="hl-quotes">'</span><span class="hl-code">,
    </span><span class="hl-quotes">'</span><span class="hl-string">author.posts</span><span class="hl-quotes">'</span><span class="hl-code">,
    </span><span class="hl-quotes">'</span><span class="hl-string">categories</span><span class="hl-quotes">'</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-code">;
</span><span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-var">$criteria</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>or</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">with</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">author.profile</span><span class="hl-quotes">'</span><span class="hl-code">,
        </span><span class="hl-quotes">'</span><span class="hl-string">author.posts</span><span class="hl-quotes">'</span><span class="hl-code">,
        </span><span class="hl-quotes">'</span><span class="hl-string">categories</span><span class="hl-quotes">'</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span>
<span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<h2 id="performing-relational-query-without-getting-related-models">3. Performing Relational query without getting related models <a class="anchor" href="#performing-relational-query-without-getting-related-models">¶</a></h2>

<p>Sometimes we need to perform query using relation but don't want to get related
models. Let's assume we have <code>User</code>s who posted many <code>Post</code>s. Post can be published
but also can be in a draft state. This is determined by <code>published</code> field in the
post model. Now we need to get all users who have published posts and we are not
interested in posts themselves. This can be achieved the following way:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$users</span><span class="hl-code">=</span><span class="hl-identifier">User</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">posts</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-comment">//</span><span class="hl-comment"> we don't want to select posts</span>
        <span class="hl-quotes">'</span><span class="hl-string">select</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">false</span><span class="hl-code">,
        </span><span class="hl-comment">//</span><span class="hl-comment"> but want to get only users with published posts</span>
        <span class="hl-quotes">'</span><span class="hl-string">joinType</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">INNER JOIN</span><span class="hl-quotes">'</span><span class="hl-code">,
        </span><span class="hl-quotes">'</span><span class="hl-string">condition</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">posts.published=1</span><span class="hl-quotes">'</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<h2 id="relational-query-options">4. Relational Query Options <a class="anchor" href="#relational-query-options">¶</a></h2>

<p>We mentioned that additional options can be specified in relationship
declaration. These options, specified as name-value pairs, are used to
customize the relational query. They are summarized as below.</p>

<ul>
<li><p><code>select</code>: a list of columns to be selected for the related AR class.
It defaults to '*', meaning all columns. Column names referenced in this option
should be disambiguated.</p></li>
<li><p><code>condition</code>: the <code>WHERE</code> clause. It defaults to empty. Column names
referenced in this option should be disambiguated.</p></li>
<li><p><code>params</code>: the parameters to be bound to the generated SQL statement.
This should be given as an array of name-value pairs.</p></li>
<li><p><code>on</code>: the <code>ON</code> clause. The condition specified here will be appended
to the joining condition using the <code>AND</code> operator. Column names referenced
in this option should be disambiguated.
This option does not apply to <code>MANY_MANY</code> relations.</p></li>
<li><p><code>order</code>: the <code>ORDER BY</code> clause. It defaults to empty. Column names
referenced in this option should be disambiguated.</p></li>
<li><p><code>with</code>: a list of child related objects that should be loaded
together with this object. Be aware that using this option inappropriately
may form an infinite relation loop.</p></li>
<li><p><code>joinType</code>: type of join for this relationship. It defaults to <code>LEFT
OUTER JOIN</code>.</p></li>
<li><p><code>alias</code>: the alias for the table associated with this relationship.
It defaults to null, meaning the table alias is the same as the relation name.</p></li>
<li><p><code>together</code>: whether the table associated with this relationship should
be forced to join together with the primary table and other tables.
This option is only meaningful for <code>HAS_MANY</code> and <code>MANY_MANY</code> relations.
If this option is set false, the table associated with the <code>HAS_MANY</code> or <code>MANY_MANY</code>
relation will be joined with the primary table in a separate SQL query, which
may improve the overall query performance since less duplicated data is returned.
If this option is set true, the associated table will always be joined with the
primary table in a single SQL query, even if the primary table is paginated.
If this option is not set, the associated table will be joined with the
primary table in a single SQL query only when the primary table is not paginated.
For more details, see the section "Relational Query Performance".</p></li>
<li><p><code>join</code>: the extra <code>JOIN</code> clause. It defaults to empty. This option
has been available since version 1.1.3.</p></li>
<li><p><code>joinOptions</code>: the property for setting post-<code>JOIN</code> operations such as
<code>USE INDEX</code>. String typed value can be used with <code>JOIN</code>s for <code>HAS_MANY</code> and <code>MANY_MANY</code>
relations, while array typed value designed to be used only with <code>MANY_MANY</code> relations.
First array element will be used for junction table <code>JOIN</code> and second array element
will be used for target table <code>JOIN</code>. This option has been available since version
1.1.15.</p></li>
<li><p><code>group</code>: the <code>GROUP BY</code> clause. It defaults to empty. Column names
referenced in this option should be disambiguated.</p></li>
<li><p><code>having</code>: the <code>HAVING</code> clause. It defaults to empty. Column names
referenced in this option should be disambiguated.</p></li>
<li><p><code>index</code>: the name of the column whose values should be used as keys
of the array that stores related objects. Without setting this option,
an related object array would use zero-based integer index.
This option can only be set for <code>HAS_MANY</code> and <code>MANY_MANY</code> relations.</p></li>
<li><p><code>scopes</code>: scopes to apply. In case of a single scope can be used like
<code>'scopes'=&gt;'scopeName'</code>, in case of multiple scopes can be used like
<code>'scopes'=&gt;array('scopeName1','scopeName2')</code>. This option has been available
since version 1.1.9.</p></li>
</ul>

<p>In addition, the following options are available for certain relationships
during lazy loading:</p>

<ul>
<li><p><code>limit</code>: limit of the rows to be selected. This option does NOT apply
to <code>BELONGS_TO</code> relation.</p></li>
<li><p><code>offset</code>: offset of the rows to be selected. This option does NOT
apply to <code>BELONGS_TO</code> relation.</p></li>
<li><p><code>through</code>: name of the model's relation that will be used as a bridge when
getting related data. This option has been available since version 1.1.7
where it can be used for <code>HAS_ONE</code> and <code>HAS_MANY</code>. Since 1.1.14 it can be used
for <code>BELONGS_TO</code> as well.</p></li>
</ul>

<p>Below we modify the <code>posts</code> relationship declaration in the <code>User</code> by
including some of the above options:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">class</span> <span class="hl-identifier">User</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span>
    <span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">posts</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_MANY</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Post</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">author_id</span><span class="hl-quotes">'</span><span class="hl-code">,
                            </span><span class="hl-quotes">'</span><span class="hl-string">order</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">posts.create_time DESC</span><span class="hl-quotes">'</span><span class="hl-code">,
                            </span><span class="hl-quotes">'</span><span class="hl-string">with</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">categories</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">profile</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_ONE</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Profile</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">owner_id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span></pre></div></div>

<p>Now if we access <code>$author-&gt;posts</code>, we would obtain the author's posts
sorted according to their creation time in descending order. Each post
instance also has its categories loaded.</p>

<blockquote class="note">
<p><strong>Note:</strong> when using eager loading such relation options as 'order', 'group',
  'having', 'limit' and 'offset' will be ignored. You should setup such parameters
  at the main model criteria level if you wish them to be applied.</p>
</blockquote>

<h2 id="disambiguating-column-names">5. Disambiguating Column Names <a class="anchor" href="#disambiguating-column-names">¶</a></h2>

<p>When a column name appears in two or more tables being joined
together, it needs to be disambiguated. This is done by prefixing the
column name with its table's alias name.</p>

<p>In relational AR query, the alias name for the primary table is fixed as <code>t</code>,
while the alias name for a relational table
is the same as the corresponding relation name by default. For example,
in the following statement, the alias name for <code>Post</code> and <code>Comment</code> is
<code>t</code> and <code>comments</code>, respectively:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">comments</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>Now assume both <code>Post</code> and <code>Comment</code> have a column called <code>create_time</code> indicating
the creation time of a post or comment, and we would like to fetch posts together
with their comments by ordering first the posts' creation time and then the comments'
creation time. We need to disambiguate the <code>create_time</code> column like the following:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">comments</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">order</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">t.create_time, comments.create_time</span><span class="hl-quotes">'</span>
<span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<blockquote class="tip">
<p><strong>Tip:</strong> The default alias of a related table is the name of the relation. Please note that if you're
  using relation from within another relation the alias will be the former relation name only and
  will not be prefixed with the parent relation. For example, the alias for 'author.group' relation is
  'group', not 'author.group'.</p>
  
  <div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">author</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">author.group</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
  <span class="hl-quotes">'</span><span class="hl-string">order</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">group.name, author.name, t.title</span><span class="hl-quotes">'</span>
<span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>
  
  <p>You can avoid the collision of tables' aliases by specifying the <a href="/doc/api/1.1/CActiveRelation#alias">alias</a> property
  of the relation.</p>
  
  <div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$comments</span><span class="hl-code">=</span><span class="hl-identifier">Comment</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
  <span class="hl-quotes">'</span><span class="hl-string">author</span><span class="hl-quotes">'</span><span class="hl-code">,
  </span><span class="hl-quotes">'</span><span class="hl-string">post</span><span class="hl-quotes">'</span><span class="hl-code">,
  </span><span class="hl-quotes">'</span><span class="hl-string">post.author</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">alias</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">p_author</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
  <span class="hl-quotes">'</span><span class="hl-string">order</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">author.name, p_author.name, post.title</span><span class="hl-quotes">'</span>
<span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>
</blockquote>

<h2 id="dynamic-relational-query-options">6. Dynamic Relational Query Options <a class="anchor" href="#dynamic-relational-query-options">¶</a></h2>

<p>We can use dynamic relational query options
in both <a href="/doc/api/1.1/CActiveRecord#with">with()</a> and the <code>with</code> option. The dynamic
options will overwrite existing options as specified in the <a href="/doc/api/1.1/CActiveRecord#relations">relations()</a>
method. For example, with the above <code>User</code> model, if we want to use eager
loading approach to bring back posts belonging to an author in <em>ascending order</em>
(the <code>order</code> option in the relation specification is descending order), we
can do the following:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-identifier">User</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">posts</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">order</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">posts.create_time ASC</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-quotes">'</span><span class="hl-string">profile</span><span class="hl-quotes">'</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>Dynamic query options can also be used when using the lazy loading approach to perform relational query. To do so, we should call a method whose name is the same as the relation name and pass the dynamic query options as the method parameter. For example, the following code returns a user's posts whose <code>status</code> is 1:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$user</span><span class="hl-code">=</span><span class="hl-identifier">User</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findByPk</span><span class="hl-brackets">(</span><span class="hl-number">1</span><span class="hl-brackets">)</span><span class="hl-code">;
</span><span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-var">$user</span><span class="hl-code">-&gt;</span><span class="hl-identifier">posts</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">condition</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">status=1</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<h2 id="relational-query-performance">7. Relational Query Performance <a class="anchor" href="#relational-query-performance">¶</a></h2>

<p>As we described above, the eager loading approach is mainly used in the scenario
when we need to access many related objects. It generates a big complex SQL statement
by joining all needed tables. A big SQL statement is preferrable in many cases
since it simplifies filtering based on a column in a related table.
It may not be efficient in some cases, however.</p>

<p>Consider an example where we need to find the latest posts together with their comments.
Assuming each post has 10 comments, using a single big SQL statement, we will bring back
a lot of redundant post data since each post will be repeated for every comment it has.
Now let's try another approach: we first query for the latest posts, and then query for their comments.
In this new approach, we need to execute two SQL statements. The benefit is that there is
no redundancy in the query results.</p>

<p>So which approach is more efficient? There is no absolute answer. Executing a single big SQL statement
may be more efficient because it causes less overhead in DBMS for parsing and executing
the SQL statements. On the other hand, using the single SQL statement, we end up with more redundant data
and thus need more time to read and process them.</p>

<p>For this reason, Yii provides the <code>together</code> query option so that we choose between the two approaches as needed.
By default, Yii uses eager loading, i.e., generating a single SQL statement, except when <code>LIMIT</code> is applied to the primary model.
We can set the <code>together</code> option in the relation declarations to be true to force a single SQL statement even when <code>LIMIT</code> is used.
Setting it to false will result in some of tables will be joined in separate SQL statements. For example, in order to use separate SQL statements
to query for the latest posts with their comments, we can declare the <code>comments</code> relation
in <code>Post</code> class as follows,</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
<span class="hl-brackets">{</span>
    <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">comments</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_MANY</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Comment</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">post_id</span><span class="hl-quotes">'</span><span class="hl-code">,
                        </span><span class="hl-quotes">'</span><span class="hl-string">together</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">false</span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span><span class="hl-code">;
</span><span class="hl-brackets">}</span></pre></div></div>

<p>We can also dynamically set this option when we perform the eager loading:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$posts</span><span class="hl-code"> = </span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span>
            <span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">comments</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                <span class="hl-quotes">'</span><span class="hl-string">together</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">false</span>
            <span class="hl-brackets">)</span><span class="hl-brackets">)</span>
        <span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<h2 id="statistical-query">8. Statistical Query <a class="anchor" href="#statistical-query">¶</a></h2>

<p>Besides the relational query described above, Yii also supports the so-called statistical query (or aggregational query). It refers to retrieving the aggregational information about the related objects, such as the number of comments for each post, the average rating for each product, etc. Statistical query can only be performed for objects related in <code>HAS_MANY</code> (e.g. a post has many comments) or <code>MANY_MANY</code> (e.g. a post belongs to many categories and a category has many posts).</p>

<p>Performing statistical query is very similar to performing relation query as we described before. We first need to declare the statistical query in the <a href="/doc/api/1.1/CActiveRecord#relations">relations()</a> method of <a href="/doc/api/1.1/CActiveRecord">CActiveRecord</a> like we do with relational query.</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">class</span> <span class="hl-identifier">Post</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span>
    <span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">commentCount</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">STAT</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Comment</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">post_id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">categoryCount</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                <span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">STAT</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Category</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">post_category(post_id, category_id)</span><span class="hl-quotes">'</span>
            <span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span></pre></div></div>

<p>In the above, we declare two statistical queries: <code>commentCount</code> calculates the number of comments belonging to a post, and <code>categoryCount</code> calculates the number of categories that a post belongs to. Note that the relationship between <code>Post</code> and <code>Comment</code> is <code>HAS_MANY</code>, while the relationship between <code>Post</code> and <code>Category</code> is <code>MANY_MANY</code> (with the joining table <code>post_category</code>). As we can see, the declaration is very similar to those relations we described in earlier subsections. The only difference is that the relation type is <code>STAT</code> here.</p>

<p>With the above declaration, we can retrieve the number of comments for a post using the expression <code>$post-&gt;commentCount</code>. When we access this property for the first time, a SQL statement will be executed implicitly to retrieve the corresponding result. As we already know, this is the so-called <em>lazy loading</em> approach. We can also use the <em>eager loading</em> approach if we need to determine the comment count for multiple posts:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">commentCount</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">categoryCount</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>The above statement will execute three SQLs to bring back all posts together with their comment counts and category counts. Using the lazy loading approach, we would end up with <code>2*N+1</code> SQL queries if there are <code>N</code> posts.</p>

<p>By default, a statistical query will calculate the <code>COUNT</code> expression (and thus the comment count and category count in the above example). We can customize it by specifying additional options when we declare it in <a href="/doc/api/1.1/CActiveRecord#relations">relations()</a>. The available options are summarized as below.</p>

<ul>
<li><p><code>select</code>: the statistical expression. Defaults to <code>COUNT(*)</code>, meaning the count of child objects.</p></li>
<li><p><code>defaultValue</code>: the value to be assigned to those records that do not receive a statistical query result. For example, if a post does not have any comments, its <code>commentCount</code> would receive this value. The default value for this option is 0.</p></li>
<li><p><code>condition</code>: the <code>WHERE</code> clause. It defaults to empty.</p></li>
<li><p><code>params</code>: the parameters to be bound to the generated SQL statement.
This should be given as an array of name-value pairs.</p></li>
<li><p><code>order</code>: the <code>ORDER BY</code> clause. It defaults to empty.</p></li>
<li><p><code>group</code>: the <code>GROUP BY</code> clause. It defaults to empty.</p></li>
<li><p><code>having</code>: the <code>HAVING</code> clause. It defaults to empty.</p></li>
</ul>

<h2 id="relational-query-with-named-scopes">9. Relational Query with Named Scopes <a class="anchor" href="#relational-query-with-named-scopes">¶</a></h2>

<p>Relational query can also be performed in combination with <a href="/doc/guide/1.1/en/database.ar#named-scopes">named scopes</a>. It comes in two forms. In the first form, named scopes are applied to the main model. In the second form, named scopes are applied to the related models.</p>

<p>The following code shows how to apply named scopes to the main model.</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">published</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">recently</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">comments</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>This is very similar to non-relational queries. The only difference is that we have the <code>with()</code> call after the named-scope chain. This query would bring back recently published posts together with their comments.</p>

<p>And the following code shows how to apply named scopes to the related models.</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">comments:recently:approved</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;
</span><span class="hl-comment">//</span><span class="hl-comment"> or since 1.1.7</span>
<span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">comments</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">scopes</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">recently</span><span class="hl-quotes">'</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">approved</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">)</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;
</span><span class="hl-comment">//</span><span class="hl-comment"> or since 1.1.7</span>
<span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">with</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">comments</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">scopes</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">recently</span><span class="hl-quotes">'</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">approved</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span>
        <span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>The above query will bring back all posts together with their approved comments. Note that <code>comments</code> refers to the relation name, while <code>recently</code> and <code>approved</code> refer to two named scopes declared in the <code>Comment</code> model class. The relation name and the named scopes should be separated by colons.</p>

<p>Occasionally you may need to retrieve a scoped relationship using a lazy-loading approach, instead of the normal eager loading method shown above.  In that case, the following syntax will do what you need:</p>

<p>~~
[php]
// note the repetition of the relationship name, which is necessary
$approvedComments = $post->comments('comments:approved');
~~</p>

<p>Named scopes can also be specified in the <code>with</code> option of the relational rules declared in <a href="/doc/api/1.1/CActiveRecord#relations">CActiveRecord::relations()</a>. In the following example, if we access <code>$user-&gt;posts</code>, it would bring back all <em>approved</em> comments of the posts.</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">class</span> <span class="hl-identifier">User</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span>
    <span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">posts</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_MANY</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Post</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">author_id</span><span class="hl-quotes">'</span><span class="hl-code">,
                </span><span class="hl-quotes">'</span><span class="hl-string">with</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">comments:approved</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span>
 
<span class="hl-comment">//</span><span class="hl-comment"> or since 1.1.7</span>
<span class="hl-reserved">class</span> <span class="hl-identifier">User</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span>
    <span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">posts</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_MANY</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Post</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">author_id</span><span class="hl-quotes">'</span><span class="hl-code">,
                </span><span class="hl-quotes">'</span><span class="hl-string">with</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                    <span class="hl-quotes">'</span><span class="hl-string">comments</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                        <span class="hl-quotes">'</span><span class="hl-string">scopes</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">approved</span><span class="hl-quotes">'</span>
                    <span class="hl-brackets">)</span><span class="hl-code">,
                </span><span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span></pre></div></div>

<blockquote class="note">
<p><strong>Note:</strong> Before 1.1.7 named scopes applied to related models must be specified in CActiveRecord::scopes.
  As a result, they cannot be parameterized.</p>
</blockquote>

<p>Since 1.1.7 it's possible to pass parameters for relational named scopes.
For example, if you have scope named <code>rated</code> in the <code>Post</code> that accepts minimum
rating of post, you can use it from <code>User</code> the following way:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$users</span><span class="hl-code">=</span><span class="hl-identifier">User</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">with</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">posts</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">scopes</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                <span class="hl-quotes">'</span><span class="hl-string">rated</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-number">5</span><span class="hl-code">,
            </span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;
 
</span><span class="hl-reserved">class</span> <span class="hl-identifier">Post</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span><span class="hl-code">
    ......
 
    </span><span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">rated</span><span class="hl-brackets">(</span><span class="hl-var">$rating</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">getDbCriteria</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">mergeWith</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">condition</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">rating=:rating</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">params</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">:rating</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-var">$rating</span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;
        </span><span class="hl-reserved">return</span> <span class="hl-var">$this</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span><span class="hl-code">
 
    ......
</span><span class="hl-brackets">}</span></pre></div></div>

<h2 id="relational-query-with-through">10. Relational Query with through <a class="anchor" href="#relational-query-with-through">¶</a></h2>

<p>When using <code>through</code>, relation definition should look like the following:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-quotes">'</span><span class="hl-string">comments</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_MANY</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">Comment</span><span class="hl-quotes">'</span><span class="hl-code">,</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">key1</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">key2</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">through</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">posts</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,</span></pre></div></div>

<p>In the above <code>array('key1'=&gt;'key2')</code>:</p>

<ul>
<li><code>key1</code> is a key defined in relation specified in <code>through</code> (<code>posts</code> is this case).</li>
<li><code>key2</code> is a key defined in a model relation points to (<code>Comment</code> in this case).</li>
</ul>

<p><code>through</code> can be used with <code>HAS_ONE</code>, <code>BELONGS_TO</code> and <code>HAS_MANY</code> relations.</p>

<h3 id="x-47x-through"><code>HAS_MANY</code> through</h3>

<div class="image"><p>HAS_MANY through ER</p><img src="/tutorial/image?type=guide&amp;version=1.1&amp;lang=en&amp;file=has_many_through.png" alt="HAS_MANY through ER" /></div>

<p>An example of <code>HAS_MANY</code> with <code>through</code> is getting users from a particular group when
users are assigned to groups via roles.</p>

<p>A bit more complex example is getting all comments for all users of a particular
group. In this case we have to use several relations with <code>through</code> in a single model:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">class</span> <span class="hl-identifier">Group</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span><span class="hl-code">
    ...
    </span><span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">roles</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_MANY</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">Role</span><span class="hl-quotes">'</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">group_id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">users</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                <span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_MANY</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">User</span><span class="hl-quotes">'</span><span class="hl-code">,</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">user_id</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">through</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">roles</span><span class="hl-quotes">'</span>
            <span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">comments</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                <span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_MANY</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">Comment</span><span class="hl-quotes">'</span><span class="hl-code">,</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">id</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">user_id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">through</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">users</span><span class="hl-quotes">'</span>
            <span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span></pre></div></div>

<h4 id="usage-examples">Usage examples</h4>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-comment">//</span><span class="hl-comment"> get all groups with all corresponding users</span>
<span class="hl-var">$groups</span><span class="hl-code">=</span><span class="hl-identifier">Group</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">users</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;
 
</span><span class="hl-comment">//</span><span class="hl-comment"> get all groups with all corresponding users and roles</span>
<span class="hl-var">$groups</span><span class="hl-code">=</span><span class="hl-identifier">Group</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">with</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">roles</span><span class="hl-quotes">'</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">users</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">;
 
</span><span class="hl-comment">//</span><span class="hl-comment"> get all users and roles where group ID is 1</span>
<span class="hl-var">$group</span><span class="hl-code">=</span><span class="hl-identifier">Group</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findByPk</span><span class="hl-brackets">(</span><span class="hl-number">1</span><span class="hl-brackets">)</span><span class="hl-code">;
</span><span class="hl-var">$users</span><span class="hl-code">=</span><span class="hl-var">$group</span><span class="hl-code">-&gt;</span><span class="hl-identifier">users</span><span class="hl-code">;
</span><span class="hl-var">$roles</span><span class="hl-code">=</span><span class="hl-var">$group</span><span class="hl-code">-&gt;</span><span class="hl-identifier">roles</span><span class="hl-code">;
 
</span><span class="hl-comment">//</span><span class="hl-comment"> get all comments where group ID is 1</span>
<span class="hl-var">$group</span><span class="hl-code">=</span><span class="hl-identifier">Group</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findByPk</span><span class="hl-brackets">(</span><span class="hl-number">1</span><span class="hl-brackets">)</span><span class="hl-code">;
</span><span class="hl-var">$comments</span><span class="hl-code">=</span><span class="hl-var">$group</span><span class="hl-code">-&gt;</span><span class="hl-identifier">comments</span><span class="hl-code">;</span></pre></div></div>

<h3 id="x-51x-through"><code>HAS_ONE</code> through</h3>

<div class="image"><p>HAS_ONE through ER</p><img src="/tutorial/image?type=guide&amp;version=1.1&amp;lang=en&amp;file=has_one_through.png" alt="HAS_ONE through ER" /></div>

<p>An example of using <code>HAS_ONE</code> with <code>through</code> is getting user address where
user is bound to address using profile. All these entities (user, profile, and address)
do have corresponding models:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">class</span> <span class="hl-identifier">User</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span><span class="hl-code">
    ...
    </span><span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">profile</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_ONE</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">Profile</span><span class="hl-quotes">'</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">user_id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">address</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                <span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_ONE</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">Address</span><span class="hl-quotes">'</span><span class="hl-code">,</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">id</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">profile_id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
                    </span><span class="hl-quotes">'</span><span class="hl-string">through</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">profile</span><span class="hl-quotes">'</span>
            <span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span></pre></div></div>

<h4 id="usage-examples">Usage examples</h4>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-comment">//</span><span class="hl-comment"> get address of a user whose ID is 1</span>
<span class="hl-var">$user</span><span class="hl-code">=</span><span class="hl-identifier">User</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findByPk</span><span class="hl-brackets">(</span><span class="hl-number">1</span><span class="hl-brackets">)</span><span class="hl-code">;
</span><span class="hl-var">$address</span><span class="hl-code">=</span><span class="hl-var">$user</span><span class="hl-code">-&gt;</span><span class="hl-identifier">address</span><span class="hl-code">;</span></pre></div></div>

<h3 id="through-on-self">through on self</h3>

<p><code>through</code> can be used for a model bound to itself using a bridge model. In our case
it's a user mentoring other users:</p>

<div class="image"><p>through self ER</p><img src="/tutorial/image?type=guide&amp;version=1.1&amp;lang=en&amp;file=through_self.png" alt="through self ER" /></div>

<p>That's how we can define relations for this case:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">class</span> <span class="hl-identifier">User</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span><span class="hl-code">
    ...
    </span><span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">mentorships</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                <span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_MANY</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">Mentorship</span><span class="hl-quotes">'</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">teacher_id</span><span class="hl-quotes">'</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">joinType</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">INNER JOIN</span><span class="hl-quotes">'</span>
            <span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">students</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                <span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_MANY</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">User</span><span class="hl-quotes">'</span><span class="hl-code">,</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">student_id</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
                    </span><span class="hl-quotes">'</span><span class="hl-string">through</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">mentorships</span><span class="hl-quotes">'</span><span class="hl-code">,</span><span class="hl-quotes">'</span><span class="hl-string">joinType</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">INNER JOIN</span><span class="hl-quotes">'</span>
            <span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span></pre></div></div>

<h4 id="usage-examples">Usage examples</h4>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-comment">//</span><span class="hl-comment"> get all students taught by teacher whose ID is 1</span>
<span class="hl-var">$teacher</span><span class="hl-code">=</span><span class="hl-identifier">User</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findByPk</span><span class="hl-brackets">(</span><span class="hl-number">1</span><span class="hl-brackets">)</span><span class="hl-code">;
</span><span class="hl-var">$students</span><span class="hl-code">=</span><span class="hl-var">$teacher</span><span class="hl-code">-&gt;</span><span class="hl-identifier">students</span><span class="hl-code">;</span></pre></div></div>

<h2 id="post-join-operations">11. Post-JOIN operations <a class="anchor" href="#post-join-operations">¶</a></h2>

<p>Since 1.1.15 additional post-JOIN operations could be set.
<code>CBaseActiveRelation::$joinOptions</code> has been added.
Consider we have the following models and relations:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">class</span> <span class="hl-identifier">User</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span>
    <span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">posts</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">HAS_MANY</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Post</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">user_id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span>
 
<span class="hl-reserved">class</span> <span class="hl-identifier">Post</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span>
    <span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">user</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">BELONGS_TO</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">User</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">user_id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">tags</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">MANY_MANY</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Tag</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">{{post_tag}}(post_id, tag_id)</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span>
 
<span class="hl-reserved">class</span> <span class="hl-identifier">Tag</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span>
    <span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">posts</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">MANY_MANY</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Post</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">{{post_tag}}(tag_id, post_id)</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span></pre></div></div>

<p>Query code examples with <code>USE INDEX</code> clauses:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$users</span><span class="hl-code">=</span><span class="hl-identifier">User</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">select</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">t.id,t.name</span><span class="hl-quotes">'</span><span class="hl-code">,
    </span><span class="hl-quotes">'</span><span class="hl-string">with</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">posts</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">alias</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">p</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">select</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">p.id,p.title</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">joinOptions</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">USE INDEX(post__user)</span><span class="hl-quotes">'</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;
 
</span><span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">select</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">t.id,t.title</span><span class="hl-quotes">'</span><span class="hl-code">,
    </span><span class="hl-quotes">'</span><span class="hl-string">with</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">tags</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">alias</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">a</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">select</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">a.id,a.name</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">joinOptions</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">USE INDEX(post_tag__tag) USE INDEX(post_tag__post)</span><span class="hl-quotes">'</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;
 
</span><span class="hl-var">$posts</span><span class="hl-code">=</span><span class="hl-identifier">Post</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">select</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">t.id,t.title</span><span class="hl-quotes">'</span><span class="hl-code">,
    </span><span class="hl-quotes">'</span><span class="hl-string">with</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">tags</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">alias</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">a</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">select</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">a.id,a.name</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">joinOptions</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                <span class="hl-quotes">'</span><span class="hl-string">USE INDEX(post_tag__tag) USE INDEX(post_tag__post)</span><span class="hl-quotes">'</span><span class="hl-code">,
                </span><span class="hl-quotes">'</span><span class="hl-string">USE INDEX(tag__name)</span><span class="hl-quotes">'</span><span class="hl-code">,
            </span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>Code above should generate following MySQL queries respectively:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">SELECT</span>
    <span class="hl-quotes">`</span><span class="hl-identifier">t</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">id</span><span class="hl-quotes">`</span> <span class="hl-reserved">AS</span> <span class="hl-quotes">`</span><span class="hl-identifier">t0_c0</span><span class="hl-quotes">`</span><span class="hl-code">, </span><span class="hl-quotes">`</span><span class="hl-identifier">t</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">name</span><span class="hl-quotes">`</span> <span class="hl-reserved">AS</span> <span class="hl-quotes">`</span><span class="hl-identifier">t0_c1</span><span class="hl-quotes">`</span><span class="hl-code">,
    </span><span class="hl-quotes">`</span><span class="hl-identifier">p</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">id</span><span class="hl-quotes">`</span> <span class="hl-reserved">AS</span> <span class="hl-quotes">`</span><span class="hl-identifier">t1_c0</span><span class="hl-quotes">`</span><span class="hl-code">, </span><span class="hl-quotes">`</span><span class="hl-identifier">p</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">title</span><span class="hl-quotes">`</span> <span class="hl-reserved">AS</span> <span class="hl-quotes">`</span><span class="hl-identifier">t1_c2</span><span class="hl-quotes">`</span>
<span class="hl-reserved">FROM</span> <span class="hl-quotes">`</span><span class="hl-identifier">tbl_user</span><span class="hl-quotes">`</span> <span class="hl-quotes">`</span><span class="hl-identifier">t</span><span class="hl-quotes">`</span>
<span class="hl-reserved">LEFT</span> <span class="hl-reserved">OUTER</span> <span class="hl-reserved">JOIN</span> <span class="hl-quotes">`</span><span class="hl-identifier">tbl_post</span><span class="hl-quotes">`</span> <span class="hl-quotes">`</span><span class="hl-identifier">p</span><span class="hl-quotes">`</span>
    <span class="hl-identifier">USE</span> <span class="hl-identifier">INDEX</span><span class="hl-brackets">(</span><span class="hl-identifier">post__user</span><span class="hl-brackets">)</span> <span class="hl-reserved">ON</span> <span class="hl-brackets">(</span><span class="hl-quotes">`</span><span class="hl-identifier">p</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">user_id</span><span class="hl-quotes">`</span><span class="hl-code">=</span><span class="hl-quotes">`</span><span class="hl-identifier">t</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">id</span><span class="hl-quotes">`</span><span class="hl-brackets">)</span><span class="hl-code">;
 
</span><span class="hl-reserved">SELECT</span>
    <span class="hl-quotes">`</span><span class="hl-identifier">t</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">id</span><span class="hl-quotes">`</span> <span class="hl-reserved">AS</span> <span class="hl-quotes">`</span><span class="hl-identifier">t0_c0</span><span class="hl-quotes">`</span><span class="hl-code">, </span><span class="hl-quotes">`</span><span class="hl-identifier">t</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">title</span><span class="hl-quotes">`</span> <span class="hl-reserved">AS</span> <span class="hl-quotes">`</span><span class="hl-identifier">t0_c2</span><span class="hl-quotes">`</span><span class="hl-code">,
    </span><span class="hl-quotes">`</span><span class="hl-identifier">a</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">id</span><span class="hl-quotes">`</span> <span class="hl-reserved">AS</span> <span class="hl-quotes">`</span><span class="hl-identifier">t1_c0</span><span class="hl-quotes">`</span><span class="hl-code">, </span><span class="hl-quotes">`</span><span class="hl-identifier">a</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">name</span><span class="hl-quotes">`</span> <span class="hl-reserved">AS</span> <span class="hl-quotes">`</span><span class="hl-identifier">t1_c1</span><span class="hl-quotes">`</span>
<span class="hl-reserved">FROM</span> <span class="hl-quotes">`</span><span class="hl-identifier">tbl_post</span><span class="hl-quotes">`</span> <span class="hl-quotes">`</span><span class="hl-identifier">t</span><span class="hl-quotes">`</span>
<span class="hl-reserved">LEFT</span> <span class="hl-reserved">OUTER</span> <span class="hl-reserved">JOIN</span> <span class="hl-quotes">`</span><span class="hl-identifier">tbl_post_tag</span><span class="hl-quotes">`</span> <span class="hl-quotes">`</span><span class="hl-identifier">tags_a</span><span class="hl-quotes">`</span>
    <span class="hl-identifier">USE</span> <span class="hl-identifier">INDEX</span><span class="hl-brackets">(</span><span class="hl-identifier">post_tag__tag</span><span class="hl-brackets">)</span> <span class="hl-identifier">USE</span> <span class="hl-identifier">INDEX</span><span class="hl-brackets">(</span><span class="hl-identifier">post_tag__post</span><span class="hl-brackets">)</span> <span class="hl-reserved">ON</span> <span class="hl-brackets">(</span><span class="hl-quotes">`</span><span class="hl-identifier">t</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">id</span><span class="hl-quotes">`</span><span class="hl-code">=</span><span class="hl-quotes">`</span><span class="hl-identifier">tags_a</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">post_id</span><span class="hl-quotes">`</span><span class="hl-brackets">)</span>
<span class="hl-reserved">LEFT</span> <span class="hl-reserved">OUTER</span> <span class="hl-reserved">JOIN</span> <span class="hl-quotes">`</span><span class="hl-identifier">tbl_tag</span><span class="hl-quotes">`</span> <span class="hl-quotes">`</span><span class="hl-identifier">a</span><span class="hl-quotes">`</span> <span class="hl-reserved">ON</span> <span class="hl-brackets">(</span><span class="hl-quotes">`</span><span class="hl-identifier">a</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">id</span><span class="hl-quotes">`</span><span class="hl-code">=</span><span class="hl-quotes">`</span><span class="hl-identifier">tags_a</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">tag_id</span><span class="hl-quotes">`</span><span class="hl-brackets">)</span><span class="hl-code">;
 
</span><span class="hl-reserved">SELECT</span>
    <span class="hl-quotes">`</span><span class="hl-identifier">t</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">id</span><span class="hl-quotes">`</span> <span class="hl-reserved">AS</span> <span class="hl-quotes">`</span><span class="hl-identifier">t0_c0</span><span class="hl-quotes">`</span><span class="hl-code">, </span><span class="hl-quotes">`</span><span class="hl-identifier">t</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">title</span><span class="hl-quotes">`</span> <span class="hl-reserved">AS</span> <span class="hl-quotes">`</span><span class="hl-identifier">t0_c2</span><span class="hl-quotes">`</span><span class="hl-code">,
    </span><span class="hl-quotes">`</span><span class="hl-identifier">a</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">id</span><span class="hl-quotes">`</span> <span class="hl-reserved">AS</span> <span class="hl-quotes">`</span><span class="hl-identifier">t1_c0</span><span class="hl-quotes">`</span><span class="hl-code">, </span><span class="hl-quotes">`</span><span class="hl-identifier">a</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">name</span><span class="hl-quotes">`</span> <span class="hl-reserved">AS</span> <span class="hl-quotes">`</span><span class="hl-identifier">t1_c1</span><span class="hl-quotes">`</span>
<span class="hl-reserved">FROM</span> <span class="hl-quotes">`</span><span class="hl-identifier">tbl_post</span><span class="hl-quotes">`</span> <span class="hl-quotes">`</span><span class="hl-identifier">t</span><span class="hl-quotes">`</span>
<span class="hl-reserved">LEFT</span> <span class="hl-reserved">OUTER</span> <span class="hl-reserved">JOIN</span> <span class="hl-quotes">`</span><span class="hl-identifier">tbl_post_tag</span><span class="hl-quotes">`</span> <span class="hl-quotes">`</span><span class="hl-identifier">tags_a</span><span class="hl-quotes">`</span>
    <span class="hl-identifier">USE</span> <span class="hl-identifier">INDEX</span><span class="hl-brackets">(</span><span class="hl-identifier">post_tag__tag</span><span class="hl-brackets">)</span> <span class="hl-identifier">USE</span> <span class="hl-identifier">INDEX</span><span class="hl-brackets">(</span><span class="hl-identifier">post_tag__post</span><span class="hl-brackets">)</span> <span class="hl-reserved">ON</span> <span class="hl-brackets">(</span><span class="hl-quotes">`</span><span class="hl-identifier">t</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">id</span><span class="hl-quotes">`</span><span class="hl-code">=</span><span class="hl-quotes">`</span><span class="hl-identifier">tags_a</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">post_id</span><span class="hl-quotes">`</span><span class="hl-brackets">)</span>
<span class="hl-reserved">LEFT</span> <span class="hl-reserved">OUTER</span> <span class="hl-reserved">JOIN</span> <span class="hl-quotes">`</span><span class="hl-identifier">tbl_tag</span><span class="hl-quotes">`</span> <span class="hl-quotes">`</span><span class="hl-identifier">a</span><span class="hl-quotes">`</span>
    <span class="hl-identifier">USE</span> <span class="hl-identifier">INDEX</span><span class="hl-brackets">(</span><span class="hl-identifier">tag__name</span><span class="hl-brackets">)</span> <span class="hl-reserved">ON</span> <span class="hl-brackets">(</span><span class="hl-quotes">`</span><span class="hl-identifier">a</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">id</span><span class="hl-quotes">`</span><span class="hl-code">=</span><span class="hl-quotes">`</span><span class="hl-identifier">tags_a</span><span class="hl-quotes">`</span><span class="hl-code">.</span><span class="hl-quotes">`</span><span class="hl-identifier">tag_id</span><span class="hl-quotes">`</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>The <code>$joinOptions</code> query option could also be set in relation declarations as follows:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">class</span> <span class="hl-identifier">Post</span> <span class="hl-reserved">extends</span> <span class="hl-identifier">CActiveRecord</span>
<span class="hl-brackets">{</span>
    <span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">user</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">BELONGS_TO</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">User</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">user_id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-quotes">'</span><span class="hl-string">tags</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">MANY_MANY</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Tag</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">{{post_tag}}(post_id, tag_id)</span><span class="hl-quotes">'</span><span class="hl-code">,
                </span><span class="hl-quotes">'</span><span class="hl-string">joinOptions</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                    <span class="hl-quotes">'</span><span class="hl-string">USE INDEX(post_tag__tag) USE INDEX(post_tag__post)</span><span class="hl-quotes">'</span><span class="hl-code">,
                    </span><span class="hl-quotes">'</span><span class="hl-string">USE INDEX(tag__name)</span><span class="hl-quotes">'</span><span class="hl-code">,
                </span><span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span>
<span class="hl-brackets">}</span></pre></div></div>
</div>
                <div class="prev-next-nav">
                            <div class="prev-topic"><a href="/doc/guide/1.1/en/database.ar">Active Record</a></div>
                                        <div class="next-topic"><a href="/doc/guide/1.1/en/database.migration">Database Migration</a></div>
                    </div>
        
		        <div class="widget-comment-list" id="comments">
	<div class="comments">
		<h3>Total 11 comments</h3>
				<div class="comment alt-0">
			<a class="cid" id="c17235" title="permalink to this comment" href="#c17235">#17235</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=17235"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=17235&amp;vote=1"><span>0</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=17235&amp;vote=0"><span>0</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/224488/">programator</a> at 2014/05/14 04:38pm</div>
			<div class="title">Class namespaces and specifying relations</div>
			<div class="content"><p>If your models are namespaced and you want to relate two models using the relations() routine, remember that the classes specified in the relations() method have to be namespaced like below:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">iDPAYMENTMETHOD</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">BELONGS_TO</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">\models\PaymentMethods</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">ID_PAYMENT_METHOD</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-quotes">'</span><span class="hl-string">iDPROJECT</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">BELONGS_TO</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">\models\Projects</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">ID_PROJECT</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-quotes">'</span><span class="hl-string">users</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">MANY_MANY</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">\models\Users</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">\models\User_Donations(ID_DONATION, ID_USER)</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>

<p>See how instead of <strong>PaymentMethods</strong> we have the fully qualified class name <strong>\models\PaymentMethods</strong></p>
</div>
					</div>
				<div class="comment alt-1">
			<a class="cid" id="c14537" title="permalink to this comment" href="#c14537">#14537</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=14537"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=14537&amp;vote=1"><span>1</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=14537&amp;vote=0"><span>0</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/141081/">Johnny Gan</a> at 2013/08/21 01:09pm</div>
			<div class="title">Using non-primary key fields as relation</div>
			<div class="content"><p>When we doing integration project, we need use client's user data, but their user table contains their user_id defined, which is different with our user_id, only user_email is same, and can be used to connect two tables.</p>

<p>So we create below relations in client's user model:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
    <span class="hl-brackets">{</span>
        <span class="hl-comment">//</span> <span class="hl-inlinedoc">NOTE:</span><span class="hl-comment"> you may need to adjust the relation name and the related</span>
        <span class="hl-comment">//</span><span class="hl-comment"> class name for the relations automatically generated below.</span>
        <span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">tools</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">BELONGS_TO</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">Tool</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">tool_id</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-comment">//</span><span class="hl-comment">if the foreign key name is different, use array('id'=&gt;'user_id')</span>
            <span class="hl-quotes">'</span><span class="hl-string">users</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">BELONGS_TO</span><span class="hl-code">, </span><span class="hl-quotes">'</span><span class="hl-string">User</span><span class="hl-quotes">'</span><span class="hl-code">, </span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">user_email</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">'</span><span class="hl-string">user_email</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-brackets">}</span></pre></div></div>

<p>Then we can use our data in client's grid view, like "users.position_title".</p>
</div>
					</div>
				<div class="comment alt-0">
			<a class="cid" id="c6723" title="permalink to this comment" href="#c6723">#6723</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=6723"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=6723&amp;vote=1"><span>5</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=6723&amp;vote=0"><span>0</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link bronze" href="/user/6843/">marcovtwout</a> at 2012/02/01 06:56am</div>
			<div class="title">Pass multiple parameters to relational named scopes.</div>
			<div class="content"><p>Addition to the guide for passing <strong>multiple parameters</strong> to relational named scopes:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-var">$users</span><span class="hl-code">=</span><span class="hl-identifier">User</span><span class="hl-code">::</span><span class="hl-identifier">model</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span><span class="hl-code">-&gt;</span><span class="hl-identifier">findAll</span><span class="hl-brackets">(</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
    <span class="hl-quotes">'</span><span class="hl-string">with</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">posts</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
            <span class="hl-quotes">'</span><span class="hl-string">scopes</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span>
                <span class="hl-comment">//</span><span class="hl-comment"> passing only one parameter</span>
                <span class="hl-quotes">'</span><span class="hl-string">rated</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-number">5</span><span class="hl-code">,
                </span><span class="hl-comment">//</span><span class="hl-comment"> passing multiple parameters</span>
                <span class="hl-comment">//</span><span class="hl-comment"> must be in the same order as function declaration</span>
                <span class="hl-quotes">'</span><span class="hl-string">anotherScope</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-number">5</span><span class="hl-code">, </span><span class="hl-reserved">true</span><span class="hl-brackets">)</span><span class="hl-code">,
            </span><span class="hl-brackets">)</span><span class="hl-code">,
        </span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span><span class="hl-code">,
</span><span class="hl-brackets">)</span><span class="hl-brackets">)</span><span class="hl-code">;</span></pre></div></div>
</div>
					</div>
				<div class="comment alt-1">
			<a class="cid" id="c4364" title="permalink to this comment" href="#c4364">#4364</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=4364"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=4364&amp;vote=1"><span>9</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=4364&amp;vote=0"><span>0</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link silver" href="/user/9/">Mike</a> at 2011/06/29 03:25am</div>
			<div class="title">Disambiguate columns in named scope</div>
			<div class="content"><p>If you use scopes with relational queries you sometimes need to make sure, that the column names don't conflict with the main table. You should therefore first obtain the right table prefix like this:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">scopes</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span>
<span class="hl-brackets">{</span>
    <span class="hl-var">$t</span><span class="hl-code">=</span><span class="hl-var">$this</span><span class="hl-code">-&gt;</span><span class="hl-identifier">getTableAlias</span><span class="hl-brackets">(</span><span class="hl-reserved">false</span><span class="hl-brackets">)</span><span class="hl-code">;
    </span><span class="hl-reserved">return</span> <span class="hl-reserved">array</span><span class="hl-brackets">(</span>
        <span class="hl-quotes">'</span><span class="hl-string">published</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-reserved">array</span><span class="hl-brackets">(</span><span class="hl-quotes">'</span><span class="hl-string">condition</span><span class="hl-quotes">'</span><span class="hl-code">=&gt;</span><span class="hl-quotes">"</span><span class="hl-var">$t</span><span class="hl-string">.published=1</span><span class="hl-quotes">"</span><span class="hl-brackets">)</span><span class="hl-code">,
    </span><span class="hl-brackets">)</span><span class="hl-code">;
</span><span class="hl-brackets">}</span></pre></div></div>
</div>
					</div>
				<div class="comment alt-0">
			<a class="cid" id="c2843" title="permalink to this comment" href="#c2843">#2843</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=2843"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=2843&amp;vote=1"><span>4</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=2843&amp;vote=0"><span>0</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link silver" href="/user/7012/">Steve Friedl</a> at 2011/02/15 11:34pm</div>
			<div class="title">Watch out for spaces!</div>
			<div class="content"><p>As of 1.1.6, spaces in a MANY_MANY relationship key will break if it has spaces in the quoted string. Example:</p>

<div class="hl-code"><div class="hl-main"><pre><span class="hl-reserved">public</span> <span class="hl-reserved">function</span> <span class="hl-identifier">relations</span><span class="hl-brackets">(</span><span class="hl-brackets">)</span> <span class="hl-brackets">{</span>
    <span class="hl-reserved">return</span><span class="hl-brackets">(</span>
       <span class="hl-quotes">'</span><span class="hl-string">pages</span><span class="hl-quotes">'</span><span class="hl-code"> =&gt; </span><span class="hl-reserved">array</span> <span class="hl-brackets">(</span><span class="hl-identifier">self</span><span class="hl-code">::</span><span class="hl-identifier">MANY_MANY</span><span class="hl-code"> , </span><span class="hl-quotes">'</span><span class="hl-string">Page</span><span class="hl-quotes">'</span><span class="hl-code"> , </span><span class="hl-quotes">'</span><span class="hl-string">userpagelist(idPage,idUser  )</span><span class="hl-quotes">'</span><span class="hl-brackets">)</span><span class="hl-code">,
        ...</span></pre></div></div>

<p>Here, the spaces after <code>idUser</code> produce an SQL error, and the fix is to remove the spaces before the parens.</p>

<p>Spaces matter!</p>
</div>
					</div>
				<div class="comment alt-1">
			<a class="cid" id="c565" title="permalink to this comment" href="#c565">#565</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=565"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=565&amp;vote=1"><span>4</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=565&amp;vote=0"><span>0</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/1885/">jamesmoey</a> at 2010/04/22 11:08pm</div>
			<div class="title">Using alias to avoid ambiguous </div>
			<div class="content"><p>If you have default scopes or named scopes, it is better to have alias parameter define as well. To avoid ambiguous problem. Because you never be able to tell if the query is a relation one or non-relation one.</p>

<p>Example,</p>

<pre>public function scopes()
{
  return array(
    'discount'=&gt;array(
      'condition'=&gt;'price.discount=1',
      'alias'=&gt;'price',
    ),
  );
}</pre>

<p>Notice that the <em>price</em> is specify in alias and condition.</p>

<p>Hopefully this will resolve some of the your ambiguous issue.</p>
</div>
					</div>
				<div class="comment alt-0">
			<a class="cid" id="c566" title="permalink to this comment" href="#c566">#566</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=566"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=566&amp;vote=1"><span>2</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=566&amp;vote=0"><span>0</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/1885/">jamesmoey</a> at 2010/04/22 10:59pm</div>
			<div class="title">Using scope on an instance</div>
			<div class="content"><pre>$this-&gt;price;</pre>

<p>This will load all the price relation belong to the product instance. To apply a discount named scope on that relation. You need to do the following,</p>

<pre>$this-&gt;price('price:discount');</pre>

<p>Notice the additional text price in the parameter.</p>
</div>
					</div>
				<div class="comment alt-1">
			<a class="cid" id="c970" title="permalink to this comment" href="#c970">#970</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=970"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=970&amp;vote=1"><span>29</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=970&amp;vote=0"><span>0</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/3621/">DD.Jarod</a> at 2010/01/17 09:44pm</div>
			<div class="title">additional info about MANY_TO_MANY configuration</div>
			<div class="content"><p>What the guide doesn't tell:
If you declare a many to many relationship, the order of keys inside the jointable declaration must be 'my_id, other_id':</p>

<pre>class Post extends CActiveRecord
{
  public function relations()
  {
    return array(
        'categories'=&gt;array(self::MANY_MANY, 'Category',
            'tbl_post_category(post_id, category_id)'),
    );
  }
}
class Category extends CActiveRecord
{
  public function relations()
  {
    return array(
        'Posts'=&gt;array(self::MANY_MANY, 'Post',
            'tbl_post_category(category_id, post_id)'),
    );
  }
}</pre>
</div>
					</div>
				<div class="comment alt-0">
			<a class="cid" id="c1039" title="permalink to this comment" href="#c1039">#1039</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=1039"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=1039&amp;vote=1"><span>1</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=1039&amp;vote=0"><span>0</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/2495/">Ivo Roper</a> at 2009/12/30 12:39am</div>
			<div class="title">extra clarity on the &#039;select&#039; and &#039;condition&#039; options</div>
			<div class="content"><p>If you include a <code>select</code> clause, you will <em>only</em> get back the fields that you specify. Be sure to disambiguate each column, and if you are using an expression in the clause you must define the select elements as items in a single array.</p>

<p>If you include a <code>where</code> option, it's <code>AND</code>'d with the generated <code>where</code> clause for the current model's primary key.</p>

<p>As far as I know, the <code>where</code> option only allows you to additionally restrict the set of directly related records. For example, you can't conditionally include other PK relations, you can only get some set of the current model's direct relations.</p>
</div>
					</div>
				<div class="comment alt-1">
			<a class="cid" id="c1153" title="permalink to this comment" href="#c1153">#1153</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=1153"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=1153&amp;vote=1"><span>0</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=1153&amp;vote=0"><span>0</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/2894/">Aissam</a> at 2009/11/20 10:24pm</div>
			<div class="title">order clause with some database/field</div>
			<div class="content"><p>pay attention with value in order clause:
depending on field name and database it could crash.
you need to escape fields sometimes.</p>

<p>eg:</p>

<p>'order'=&gt;'lists.order ASC'</p>

<p>will crash on sqlite.
CDbCommand failed to prepare the SQL statement: SQLSTATE[HY000]: General error: 1 near "order": syntax error</p>

<p>so to work you need to escape it</p>

<p>'order'=&gt;'lists."order"'</p>
</div>
					</div>
				<div class="comment alt-0">
			<a class="cid" id="c1217" title="permalink to this comment" href="#c1217">#1217</a>
			<a class="widget-reporter" title="Please report to us if you find any inappropriate content." href="/site/report/?type=Comment&amp;id=1217"><span>report it</span></a>			<div class="widget-voter"><ul>
	<li class="vote up"><a title="Thumb up" class="g-login" href="/site/vote/?type=Comment&amp;id=1217&amp;vote=1"><span>0</span></a></li>
	<li class="vote down"><a title="Thumb down" class="g-login" href="/site/vote/?type=Comment&amp;id=1217&amp;vote=0"><span>0</span></a></li>
</ul>
<div class="clear"></div></div>			<div class="meta"><a class="g-user-rank-link" href="/user/662/">dreamynsx</a> at 2009/10/21 11:29am</div>
			<div class="title">accessing relational data</div>
			<div class="content"><p>say you have class Foo and class Bar which maps to database tables 'foo' and 'bar' respectively.</p>

<p>table bar has a field called publish_date.</p>

<p>You do a join on 'foo' and 'bar' via active record find() method.</p>

<p>$criteria-&gt;join = "JOIN bar on bar.foo_id = foo.id";
$foo = Foo::model()-&gt;find($criteria);</p>

<p>Now you want to access the publish_date data but if you do</p>

<p>$foo-&gt;publish_date, it will say property not found.</p>

<p>To access it, you can setup relational rule like above and then access it like $foo-&gt;bar-&gt;publish_date.</p>

<p>But if you don't want to setup relational data, you can just add property publish_date to Foo class, and then access it like $foo-&gt;publish_date.  It will reference the publish_date as result of the relational data.</p>

<p>Came in handy.</p>
</div>
					</div>
			</div>
	<div id="comment-add">
		<h3 id="add-comment">Leave a comment</h3>

			<p>Please <a class="g-login" rel="/doc/guide/1.1/en/database.arr#add-comment" href="#">login</a> to leave your comment.</p>
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
