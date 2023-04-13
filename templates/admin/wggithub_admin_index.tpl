<!-- Header -->
<{include file='db:wggithub_admin_header.tpl' }>

<!-- Index Page -->
<div class="top"><{$index|default:''}></div>
<{if !empty($error)}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wggithub_admin_footer.tpl' }>
