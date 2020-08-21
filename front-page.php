<?php
/*
 * Hop Yat Church main template file
 */
?>

<?php get_header() ?>
<div class="container-xl pb-3">
	<div class="row mx-md-n2">
		<div class="col-md-8 px-0 px-md-2 order-md-last">
			<div class="card">
				<h5 class="card-header d-flex justify-content-between">
					<div>主任牧師的話</div>
					<div>許開明牧師</div>
				</h5>
				<div class="card-body my-blog-text">
					<div class="d-flex justify-content-between align-items-baseline">
						<h3 class="text-primary font-weight-bold">
							健康最重要！
						</h3>
						<h6>
							2020年8月
						</h6>
					</div>
					<div>
						<p>
							<img class="my-portrait" src="<?php echo esc_url(get_template_directory_uri()) ?>/images/Hui.jpg">
						</p>
					</div>
					<div>
						<p>
							世紀疫情嚴峻，近日香港連續多天確診人數過百，情況令人擔心。現今若然問大家：「什麼是你生命中，最重要的東西？」我相信許多人的回答是「健康最重要！」其實，一個人隨著年齡的增加自然地會感到「健康最重要」，尤其是那些百病纏身的人。
						</p>
						<p>
							基督的身體 (教會)
							，正如人的身體一樣，也需要健康。自古以來，教會面對著一股強大的外來勢力，就是世俗化。世俗化誘使信徒群體向世界妥協，以致教會失去聖潔；而教會內部又有另一股勢力，就是分黨分派，這會使教會不能合一。外在的世俗化，會使教會腐化；內在的分黨分派，會使教會分化；這兩股內外惡勢力，會使基督的身體
							(教會)失去抗體、免疫能力，和生命力， 結果導致生病和死亡，不容忽視。是故，如何使我們的教會健康起來，實在刻不容緩！
						</p>
						<p>
							翻查歷史，教會早於1999年根據「健康教會的八種特質」提出「八大致力」，並整合而成「六大關注」，以期盼能逐步建立健康的教會。於2019年教友進修會中，四個單位堂的弟兄姊妹於會中提出不少具體的計劃，立志獻心共建健康教會。然而，在最近堂主任會檢視「六大關注」事工進展情況時，大家都感到須加多一把勁推動，因此提出一連串的計劃
							，將陸續在這平台登載，其中一項是每月在合一周刊設有「主任牧師的話」 ，藉此激勵大家起來，同心推動六大關注，共建健康成熟的教會。
						</p>
						<p>
							健康的教會，繫於健康的生命，所以信徒當追求健康的生命，才會有健康的教會。在此疫情嚴峻的時刻，特別送上聖經中的一句話來祝福大家： 「 親愛的兄弟啊，我願你凡事興盛，身體健壯，正如你的靈魂興盛一樣。 」( 約叁1:2
							)弟兄姊妹，請記住「健康最重要」
							，我們自己當努力保持健康的身體
							，並且共建健康的基督身體（教會） ，誠心所願。
						</p>
					</div>
				</div>
			</div>
			<div class="card">
				<h5 class="card-header">誠邀弟兄姊妹參與網上主日崇拜</h5>
				<div class="card-body">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/8t84UKwVmic?rel=0" allowfullscreen></iframe>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 px-0 px-md-2 order-md-first">
			<div class="card">
				<h5 class="card-header">主日祟拜</h5>
				<div class="card-body">
					<h5 class="card-title"><?php the_field('service_type') ?></h5>
					<p class="card-text">日期：<?php the_field('service_date') ?><br />時間：<?php the_field('service_time') ?>
						<p>
							<h5>[ 講 道 ]</h5>
						</p>
						題旨：<?php the_field('service_title') ?><br />講員：<?php the_field('service_speaker') ?><br />
						經文：<?php the_field("service_scripture") ?></p>
				</div>
			</div>
			<div class="my-poster border rounded-lg">
				<img src="<?php echo esc_url(get_template_directory_uri()) ?>/images/200702 sunday school woman's role.jpg">
			</div>
			<div class="my-poster border rounded-lg">
				<img src="<?php echo esc_url(get_template_directory_uri()) ?>/images/200727 sunday school exodus.jpg">
			</div>
			<div class="card">
				<h5 class="card-header">Featured</h5>
				<div class="card-body">
					<h5 class="card-title"></h5>
					<p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias consequatur animi beatae asperiores
						laborum pariatur nam? Delectus enim nostrum rerum voluptatibus itaque qui eveniet fugiat, soluta dicta? Pariatur,
						voluptates eligendi.</p>
					<a href="#" class="btn btn-primary">Go somewhere</a>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer() ?>