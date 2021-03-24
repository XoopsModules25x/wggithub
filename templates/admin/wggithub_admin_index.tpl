<!-- Header -->
<{includeq file='db:wggithub_admin_header.tpl' }>

<!-- Index Page -->
<div class="top"><{$index|default:''}></div>
<{if $error|default:''}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<!-- Footer -->
<{includeq file='db:wggithub_admin_footer.tpl' }>
