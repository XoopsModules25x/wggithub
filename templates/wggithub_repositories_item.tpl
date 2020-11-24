<i id='repoId_<{$repository.repo_id}>'></i>
<div class='panel-heading'>
</div>
<div class='panel-body'>
	<span class='col-sm-9 justify'><{$repository.name}></span>
	<span class='col-sm-9 justify'><{$repository.htmlurl}></span>
	<span class='col-sm-9 justify'><{$repository.readme}></span>
</div>
<div class='panel-foot'>
	<div class='col-sm-12 right'>
		<{if $showItem}>
			<a class='btn btn-success right' href='repositories.php?op=list&amp;#repoId_<{$repository.repo_id}>' title='<{$smarty.const._MA_WGGITHUB_REPOSITORIES_LIST}>'><{$smarty.const._MA_WGGITHUB_REPOSITORIES_LIST}></a>
		<{else}>
			<a class='btn btn-success right' href='repositories.php?op=show&amp;repo_id=<{$repository.repo_id}>' title='<{$smarty.const._MA_WGGITHUB_DETAILS}>'><{$smarty.const._MA_WGGITHUB_DETAILS}></a>
		<{/if}>
		<{if $permEdit}>
			<a class='btn btn-primary right' href='repositories.php?op=edit&amp;repo_id=<{$repository.repo_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-danger right' href='repositories.php?op=delete&amp;repo_id=<{$repository.repo_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
		<{/if}>
	</div>
</div>
