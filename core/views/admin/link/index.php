<?php
/**
 * @link http://www.simpleforum.org/
 * @copyright Copyright (c) 2015 Simple Forum
 * @author Jiandong Yu admin@simpleforum.org
 */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'Ссылки';
?>

<div class="row">
<!-- sf-left start -->
<div class="col-md-8 sf-left">

<ul class="list-group sf-box">
	<li class="list-group-item">
		<p class='fr'><?php echo Html::a('Добавить', ['add']); ?></p>
		<?php
			echo Html::a('Админпанель', ['admin/setting/all']), '&nbsp;/&nbsp;', $this->title;
		?>
	</li>
	<li class="list-group-item list-group-item-info"><strong>Ссылка</strong></li>
	<li class="list-group-item">
		<ul>
		<?php
			foreach($links as $link) {
				echo '<li>', $link['name'], '&nbsp;(', Html::a($link['url'], $link['url']), ')&nbsp;|&nbsp;',
					Html::a('Правка', ['edit', 'id'=>$link['id']]), '&nbsp;|&nbsp;',
					Html::a('Удалить', ['delete', 'id'=>$link['id']], [
					    'data' => [
					        'confirm' => 'Примечание: После удаления восстановление невозможно! Подтвердите удаление!',
					        'method' => 'post',
					]]), '</li>';
			}
		?>
		</ul>
	</li>
	<li class="list-group-item item-pagination">
	<?php
	echo LinkPager::widget([
	    'pagination' => $pages,
		'maxButtonCount'=>5,
	]);
	?>
	</li>
</ul>


</div>
<!-- sf-left end -->

<!-- sf-right start -->
<div class="col-md-4 sf-right">
<?php echo $this->render('@app/views/common/_admin-right'); ?>
</div>
<!-- sf-right end -->
</div>
