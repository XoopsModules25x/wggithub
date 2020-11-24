<{include file='db:wggithub_header.tpl' }>

<div class='wggithub-linetitle'><{$smarty.const._MA_WGGITHUB_INDEX_LATEST_LIST}></div>
<{if $directoriesCount > 0}>
	<ul class="nav nav-tabs">
		<li class="<{if $menu == 0}>active<{/if}>"><a data-toggle="tab" href="#home">Home</a></li>
		<{foreach item=directory from=$directories}>
		<li class="<{if $menu == $directory.id}>active<{/if}>"><a data-toggle="tab" href="#menu<{$directory.id}>"><{$directory.name}></a></li>
		<{/foreach}>
	</ul>

	<div class="tab-content">
		<div id="home" class="tab-pane fade <{if $menu == 0}>in active<{/if}>">
			<p class="center"><img class="tabcontent-logo" src="<{$wggithub_image_url}>/logoModule.png" alt="<{$smarty.const._MA_WGGITHUB_TITLE}>" title="<{$smarty.const._MA_WGGITHUB_TITLE}>"></p>
			<h3><{$smarty.const._MA_WGGITHUB_DESC}></h3>
			<p><{$smarty.const._MA_WGGITHUB_INDEX_DESC}></p>
			<p class="tabcontent-lastupdate"><{$smarty.const._MA_WGGITHUB_INDEX_LASTUPDATE}>: <{$lastUpdate}> GMT</p>
			<{if $apiexceed}>
				<p><{$smarty.const._MA_WGGITHUB_READGH_ERROR_APILIMIT}></p>
			<{elseif $apierror}>
				<p><{$smarty.const._MA_WGGITHUB_READGH_ERROR_APIOTHER}></p>
			<{else}>
				<p><{$smarty.const._MA_WGGITHUB_INDEX_UPTODATE}></p>
			<{/if}>
		</div>
		<{foreach item=directory from=$directories}>
		<div id="menu<{$directory.id}>" class="tab-pane fade <{if $menu == $directory.id}>in active <{/if}>">
			<div class="col-xs-12 tab-content-info"><h4><{$directory.countRepos}></h4></div>
			<div class="col-xs-3"> <!-- required for floating -->
				<!-- Nav tabs -->
				<ul class="nav nav-tabs tabs-left sideways">
					<{if $directory.previousRepos}>
						<li class=""><a  id="btn_previous" href="index.php?op=list<{$directory.previousOp}>&amp;menu=<{$directory.id}>"> ... </a></li>
					<{/if}>
					<{foreach name=repo item=repo from=$directory.repos}>
					<li class="<{if $smarty.foreach.repo.first}>active<{/if}>"><a href="#tabdetail<{$repo.id}>" data-toggle="tab"><{$repo.name}></a></li>
					<{/foreach}>
					<{if $directory.nextRepos}>
						<li class="">
							<a id="btn_next" href="index.php?op=list<{$directory.nextOp}>&amp;menu=<{$directory.id}>"> ... </a>
						</li>
					<{/if}>
				</ul>
			</div>
			<div class="col-xs-9">
				<!-- Tab panes -->
				<div class="tab-content">
					<{foreach name=repo item=repo from=$directory.repos}>
						<div class="tab-pane<{if $smarty.foreach.repo.first}> active<{/if}>" id="tabdetail<{$repo.id}>">
							<div class="col-xs-12 sm-12 tabcontent-headline">
								<h3><{$smarty.const._MA_WGGITHUB_REPOSITORY}>: <{$repo.name}></h3>
							</div>
							<div class="clearfix"></div>
							<div class="col-xs-12 col-sm-6 tabcontent-headline">
								<p><i class="fa fa-calendar"></i> <{$smarty.const._MA_WGGITHUB_REPOSITORY_CREATEDAT}>: <{$repo.createdat}></p>
							</div>
							<div class="col-xs-12 col-sm-6 tabcontent-headline">
								<p><i class="fa fa-calendar"></i> <{$smarty.const._MA_WGGITHUB_REPOSITORY_UPDATEDAT}>: <{$repo.updatedat}></p>
							</div>
							<{if $repo.releases}>
								<div class="col-xs-12 col-sm-12 tabcontent-headline">
									<p class=""><{$smarty.const._MA_WGGITHUB_RELEASES}>:</p>
									<{foreach item=release from=$repo.releases}>
										<p class="">
											<{$release.name}>
											<a class='btn btn-info btn-sm' href="<{$release.zipballurl}>" title="<{$smarty.const._MA_WGGITHUB_RELEASE_ZIP}>"><{$smarty.const._MA_WGGITHUB_RELEASE_ZIP}></a>
											<a class='btn btn-info btn-sm' href="<{$release.tarballurl}>" title="<{$smarty.const._MA_WGGITHUB_RELEASE_TAR}>"><{$smarty.const._MA_WGGITHUB_RELEASE_TAR}></a>
										</p>
									<{/foreach}>
								</div>
							<{/if}>
							<div class="col-xs-12 col-sm-12 tabcontent-headline">
								<p class=""><a class='btn btn-primary right' href="<{$repo.htmlurl}>" title="<{$smarty.const._MA_WGGITHUB_REPOSITORY_GOTO}>"><{$smarty.const._MA_WGGITHUB_REPOSITORY_GOTO}></a></p>
							</div>
							<div class="col-xs-12 sm-12 tabcontent-content"><{$repo.readme.content_clean}></div>
						</div>
					<{/foreach}>
				</div>
			</div>

			<div class="clearfix"></div>

		</div>
		<{/foreach}>

	</div>
	<{/if}>

<script>
	var el = document.getElementById('btn_next'),
			elClone = el.cloneNode(true);

	el.parentNode.replaceChild(elClone, el);
</script>

<{include file='db:wggithub_footer.tpl' }>
