<!DOCTYPE html>
<html lang="$ContentLocale">
<head>
	<% base_tag %>
	<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	$MetaTags(false)
    <% if $SiteConfig.Favicon %>
        <link rel="shortcut icon" href="{$SiteConfig.Favicon.ScaleMaxWidth(128).Link()}" />
    <% else %>
        <link rel="shortcut icon" href="$resourceURL('themes/whittendav/images/favicon.ico')" />
    <% end_if %>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
</head>
<body<% if $Link = '/home' %> class="home"<% end_if %>>
<% include Header %>
<div class="main" role="main" id="main">
	<div class="inner">
		$Layout
	</div>
</div>
<% include SearchModal %>
<% include Footer %>
</body>
</html>
