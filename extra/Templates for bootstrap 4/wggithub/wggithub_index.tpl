<{include file='db:wggithub_header.tpl' }>

<{if $error}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<{if $directoriesCount > 0}>
	<!-- filter area -->
	<div class="tab-filter">
		<{$smarty.const._MA_WGGITHUB_FILTER_RELEASE}>:
		<div class="btn-group btn-group-sm" role="group" aria-label="Filter Releases">
			<button id="relfinal" <{if $release !='final'}>onclick="executeClick(this, 'release', 'index.php?op=list&release=final&sortby=<{$sortby}>')"<{/if}> type="button" class="btn btn-primary btn-rounded <{if $release =='final'}>disabled<{/if}>"><{$smarty.const._MA_WGGITHUB_FILTER_RELEASE_FINAL}></button>
			<button id="relany" <{if $release !='any'}>onclick="executeClick(this, 'release', 'index.php?op=list&release=any&sortby=<{$sortby}>')"<{/if}> type="button" class="btn btn-primary btn-rounded <{if $release =='any'}>disabled<{/if}>"><{$smarty.const._MA_WGGITHUB_FILTER_RELEASE_ANY}></button>
			<button id="relall" <{if $release !='all'}>onclick="executeClick(this, 'release', 'index.php?op=list&release=all&sortby=<{$sortby}>')"<{/if}> type="button" class="btn btn-primary btn-rounded <{if $release =='all'}>disabled<{/if}>"><{$smarty.const._MA_WGGITHUB_FILTER_RELEASE_ALL}></button>
		</div>
		<{$smarty.const._MA_WGGITHUB_FILTER_SORTBY}>:
		<div class="btn-group btn-group-sm" role="group" aria-label="Filter Releases">
			<button id="sortbyname" onclick="executeClick(this, 'sortby', 'index.php?op=list&sortby=name&release=<{$release}>')" type="button" class="btn btn-primary btn-rounded <{if $sortby =='name'}>disabled<{/if}>"><{$smarty.const._MA_WGGITHUB_FILTER_SORTBY_NAME}></button>
			<button id="sortbyupdate" onclick="executeClick(this, 'sortby', 'index.php?op=list&sortby=update&release=<{$release}>')" type="button" class="btn btn-primary btn-rounded <{if $sortby =='update'}>disabled<{/if}>"><{$smarty.const._MA_WGGITHUB_FILTER_SORTBY_UPDATE}></button>
		</div>
	</div>

	<ul class="nav nav-tabs">
		<li class="nav-item"><a class="nav-link <{if $menu == 0}>active<{/if}>" data-toggle="tab" href="#home">Home</a></li>
		<{foreach item=directory from=$directories}>
		<li class="nav-item"><a class="nav-link <{if $menu == $directory.id}>active<{/if}>" data-toggle="tab" href="#menu<{$directory.id}>"><{$directory.name}></a></li>
		<{/foreach}>
	</ul>
	
	<div class="tab-content tab-content-main">
		<div id="home" class="maintab tab-pane fade <{if $menu == 0}>show active<{/if}> mx-2">
			<p class="center"><img class="tabcontent-logo" src="assets/images/logoModule.png" alt="<{$smarty.const._MA_WGGITHUB_TITLE}>" title="<{$smarty.const._MA_WGGITHUB_TITLE}>"></p>
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
		<div id="menu<{$directory.id}>" class="maintab tab-pane fade <{if $menu == $directory.id}>show active<{/if}>">
			<div class="col-12 tab-content-info">
				<h4>
					<{$directory.countRepos}>
					<{if $permGlobalRead && ($directory.dir_autoupdate == 0)}>
					<a id="btn_update" class="btn btn-primary btn-sm pull-right" href="index.php?op=update_dir&amp;dir_name=<{$directory.name}>&amp;start=<{$start}>&amp;limit=<{$limit}>"><{$smarty.const._MA_WGGITHUB_DIRECTORY_UPDATE}> </a>
					<{/if}>
				</h4>
				<p><{$directory.descr}></p>
			</div>
			<div class="row">
				<div class="col-3 bg-secondary"> <!-- required for floating -->

					<!-- Nav tabs for each directory -->
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<{if $directory.previousRepos}>
							<a class="nav-link" id="btn_previous" href="index.php?op=list<{$directory.previousOp}>&amp;menu=<{$directory.id}>"> ... </a>
						<{/if}>
						<{foreach name=repo item=repo from=$directory.repos}>
						<a class="nav-link <{if $smarty.foreach.repo.first}>active<{/if}>" href="#tabdetail<{$repo.id}>" data-toggle="tab"><{$repo.name}></a>
						<{/foreach}>
						<{if $directory.nextRepos}>
							<a id="btn_next" href="index.php?op=list<{$directory.nextOp}>&amp;menu=<{$directory.id}>"> ... </a>							
						<{/if}>
					</div>
				</div>
				<div class="col-9">
					<!-- Tab panes -->
					<div class="tab-content">
						<{foreach name=repo item=repo from=$directory.repos}>
							<div class="tab-pane fade<{if $smarty.foreach.repo.first}> show active<{/if}>" id="tabdetail<{$repo.id}>" role="tabpanel">
								<div class="col-xs-12 sm-12 tabcontent-headline">
									<h4><{$smarty.const._MA_WGGITHUB_REPOSITORY}>: <{$repo.name}></h4>
								</div>
								<div class="clearfix"></div>
								<div class="codixs-12 col-sm-6 tabcontent-headline">
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
												<{$release.name}> <span style="font-size: smaller">(<{$release.publishedat}>)</span>
												<a class='btn btn-info btn-sm' href="<{$release.zipballurl}>" title="<{$smarty.const._MA_WGGITHUB_RELEASE_ZIP}>"><{$smarty.const._MA_WGGITHUB_RELEASE_ZIP}></a>
												<a class='btn btn-info btn-sm' href="<{$release.tarballurl}>" title="<{$smarty.const._MA_WGGITHUB_RELEASE_TAR}>"><{$smarty.const._MA_WGGITHUB_RELEASE_TAR}></a>
											</p>
										<{/foreach}>
									</div>
								<{/if}>
								<div class="col-xs-12 col-sm-12 tabcontent-headline">
									<p class=""><a class='btn btn-primary right' href="<{$repo.htmlurl}>" title="<{$smarty.const._MA_WGGITHUB_REPOSITORY_GOTO}>" target="_blank"><{$smarty.const._MA_WGGITHUB_REPOSITORY_GOTO}></a></p>
								</div>
								<{if $repo.readme.gitbook_link}>
									<div class="col-xs-12 col-sm-12 tabcontent-headline">
										<p class=""><a class='btn btn-warning right' href="<{$repo.readme.gitbook_link}>" title="<{$smarty.const._MA_WGGITHUB_GITBOOK_GOTO}>" target="_blank"><{$smarty.const._MA_WGGITHUB_GITBOOK_GOTO}></a></p>
									</div>
								<{/if}>
								<div class="col-xs-12 sm-12 tabcontent-content">
									<{if $permReadmeUpdate}>
									<i class="fa fa-re"></i>
										<a class='btn btn-primary btn-sm pull-right' href="index.php?op=update_readme&amp;repo_id=<{$repo.id}>&amp;repo_user=<{$repo.user}>&amp;repo_name=<{$repo.name}>" title="<{$smarty.const._MA_WGGITHUB_README_UPDATE}>"><{$smarty.const._MA_WGGITHUB_README_UPDATE}></a></p>
									<{/if}>
									<{$repo.readme.content_clean}>
								</div>
							</div>
						<{/foreach}>
					</div>
				</div>
			<!--<div class="clearfix"></div>-->
			</div>

		</div>
		<{/foreach}>

	</div>
	<{/if}>

<script type="text/javascript">
	var el = document.getElementById('btn_next'),
			elClone = el.cloneNode(true);

	el.parentNode.replaceChild(elClone, el);

	if (location.protocol == 'https:') {
		var imgs = document.getElementsByTagName("img");
		var imgSrc = '';

		for (var i = 0; i < imgs.length; i++) {
			imgSrc = imgs[i].src;
			imgSrc = imgSrc.replace("http:", "https:");
			imgs[i].src = imgSrc;
		}
	}

</script>
<script type="text/javascript">
	var executeClick = function(el, group, href)
	{
		if ('release' == group) {
			document.getElementById('relfinal').classList.remove("disabled");
			document.getElementById('relany').classList.remove("disabled");
			document.getElementById('relall').classList.remove("disabled");
			document.getElementById(el.id).classList.add("disabled");
		};
		if ('sortby' == group) {
			document.getElementById('sortbyname').classList.remove("disabled");
			document.getElementById('sortbyupdate').classList.remove("disabled");
			document.getElementById(el.id).classList.add("disabled");
		};
		var tabid = $('.tab-content-main .maintab.active').attr('id');
		var url;
		url = href + '&menu=' + tabid;

		window.location.href=url;
	}
</script>

<{include file='db:wggithub_footer.tpl' }>
