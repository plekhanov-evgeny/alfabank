<?php

echo '<h1>Alfa Bank</h1>';
echo '<h2>Module PHP</h2>';
echo '<h3>Task 1: Умножить каждое значение массива на два</h3>';
// Task 1: Умножить каждое значение массива на два
$a = [
	   1,
	   2,
	   [
			 [
				    9,
				    10,
				    [11],
			 ],
			 7,
			 8,
	   ],
	   3,
	   5,
];
array_walk_recursive(
	   $a, function (&$value) {
	if (is_numeric($value)) {
		$value *= 2;
	}
}
);

echo '<pre>';
print_r($a);
echo '</pre>';

echo '<h3>Task 2: Как исправить скрипт, чтобы экземпляр класса b выводил корректную информацию о себе?</h3>';
// Task 2: Как исправить скрипт, чтобы экземпляр класса b выводил корректную информацию о себе?
// Ответ: Необходимо добавить static, чтобы класс не вычислялся по отношению к классу, в котором вызываемый метод определён, а будет вычисляться на основе информации в ходе исполнения
// Ответ 2: Можно переопределить метод getType и тогда данные будут подставляться из вызываемого объекта

class A
{
	const TYPE = 'A Class';

	// Вариант 1
	public function getType()
	{
		echo 'This is class: ' . static::class . ', type ' . static::TYPE . '<br>';
	}
}

class B extends A
{
	const TYPE = 'B Class';
}

echo '<p>Необходимо добавить static, чтобы класс не вычислялся по отношению к классу, в котором вызываемый метод определён, а будет вычисляться на основе информации в ходе исполнения</p>';
$aClass = new A();
$bClass = new B();
$aClass->getType();
$bClass->getType();

class A1
{
	const TYPE = 'A1 Class';

	public function getType()
	{
		echo 'This is class: ' . __CLASS__ . ', type ' . self::TYPE . '<br>';
	}
}

class B1 extends A1
{
	const TYPE = 'B1 Class';

	public function getType()
	{
		echo 'This is class: ' . __CLASS__ . ', type ' . static::TYPE . '<br>';
	}
}

echo '<p>Можно переопределить метод getType и тогда данные будут подставляться из вызываемого объекта</p>';
$aClass = new A1();
$bClass = new B1();

$aClass->getType();
$bClass->getType();

echo '<h3>Task 3: Вывести дерево с рекурсией / без рекурсии в следующем виде</h3>';
echo '<p>Должно получиться</p>';
echo '<ul>';
echo '<li>1</li>';
echo '<li>1.2</li>';
echo '<li>1.2.5</li>';
echo '<li>1.2.6</li>';
echo '<li>1.2.6.8</li>';
echo '<li>1.3</li>';
echo '<li>1.3.7</li>';
echo '<li>1.4</li>';
echo '</ul>';
$tree = [
	   [
	   	   'id'		=> '8',
		   'parent_id'	=> '6',
	   ],
	   [
	   	   'id'		=> '2',
		   'parent_id'	=> '1',
	   ],
	   [
	   	   'id'		=> '3',
		   'parent_id'	=> '1',
	   ],
	   [
	   	   'id'		=> '4',
		   'parent_id'	=> '1',
	   ],
	   [
	   	   'id'		=> '5',
		   'parent_id'	=> '2',
	   ],
	   [
	   	   'id'		=> '1',
		   'parent_id'	=> '0',
	   ],
	   [
	   	   'id'		=> '6',
		   'parent_id'	=> '2',
	   ],
	   [
	   	   'id'		=> '7',
		   'parent_id'	=> '3',
	   ],
];

class Tree
{
	static public function recurcive($tree, $node = [])
	{
		if ( $node['id'] ) {
			$found_key = array_search($node['parent_id'], array_column($tree, 'id'));
			if ( $tree[$found_key]['parent_id'] != 0 ) {
				$str = self::recurcive($tree, $tree[$found_key]);
				$str .= '.' . $tree[$found_key]['id'];
				return $str;
			} else {
				return $tree[$found_key]['id'];
			}
		}
		foreach ($tree as $branch) {
			if ( $branch['parent_id'] == '0' ) {
				$arr[] = $branch['id'];
				continue;
			}
			$str = self::recurcive($tree, $branch);
			$str .= '.' . $branch['id'];
			$arr[] = $str;
		}

		return $arr;
	}

	static public function noRecurcive($tree) {
		foreach ($tree as $branch) {
			if ($branch['parent_id'] == 0) {
				$arr[] = $branch['id'];
				$strZero = $branch['id'];
			} else {
				$found_key = array_search($branch['parent_id'], array_column($tree, 'id'));
				if ( $tree[$found_key]['parent_id'] == 0 ) {
					$arr[] = $strZero . '.' . $branch['id'];
				} else {
					$found_keyNext = array_search($tree[$found_key]['parent_id'], array_column($tree, 'id'));
					if ( $tree[$found_keyNext]['parent_id'] == 0 ) {
						$arr[] = $strZero . '.' . $tree[$found_key]['id'] . '.' . $branch['id'];
					} else {
						$arr[] = $strZero . '.' . $tree[$found_keyNext]['id'] . '.' . $tree[$found_key]['id'] . '.' . $branch['id'];
					}
				}
			}
		}
		return $arr;
	}
}
echo '<p>Вывод используя метод с рекурсией</p>';
echo '<ul>';
$arrTree = Tree::recurcive($tree);
asort($arrTree);
foreach ($arrTree as $branch) {
	echo '<li>' . $branch . '</li>';
}
echo '</ul>';

$parentSort  = array_column($tree, 'parent_id');
array_multisort($parentSort, SORT_ASC, $tree);
$arrTree = Tree::noRecurcive($tree);
asort($arrTree);
echo '<p>Вывод используя метод без рекурсии</p>';
echo '<ul>';
foreach ($arrTree as $branch) {
	echo '<li>' . $branch . '</li>';
}
echo '</ul>';
?>

<style>
	body {
		color: #ffffff;
		background: #000000;
	}
	code {
		color: green;
	}
</style>
<h2>Module SQL - написать запросы под любую СУБД</h2>
<h3>Кто из пользователей не посещал ни одной страницы?</h3>
<p>Вывести: логин, фио</p>
<code>
	SELECT UT.LOGIN, UT.FIO <br>
	FROM USERS_TAB AS UT LEFT JOIN LOG_TAB AS LT ON UT.LOGIN = LT.USER_LOGIN <br>
	WHERE LT.USER_LOGIN IS NULL
</code>
<h3>Какие страницы используют департаменты?</h3>
<p>Вывести: название департамента, название страницы</p>
<code>
	SELECT DISTINCT DEP.DEP_NAME, LT.PAGE_NAME <br>
	FROM departament AS DEP LEFT JOIN USERS_TAB AS UT ON DEP.DEP_ID = UT.DEPARTMENT_ID <br>
	LEFT JOIN LOG_TAB AS LT ON UT.LOGIN = LT.USER_LOGIN <br>
	WHERE LT.PAGE_NAME <> ''
</code>
<h3>Какой департамент активнее всего пользуется страницей account.php</h3>
<p>Вывести: название департамента, кол-во посещений</p>
<code>
	SELECT DEP.DEP_NAME, COUNT(LT.PAGE_NAME) AS CNT <br>
	FROM departament AS DEP LEFT JOIN USERS_TAB AS UT ON DEP.DEP_ID = UT.DEPARTMENT_ID <br>
	LEFT JOIN LOG_TAB AS LT ON UT.LOGIN = LT.USER_LOGIN <br>
	WHERE LT.PAGE_NAME = 'account.php' <br>
	GROUP BY DEP.DEP_NAME
</code>
<h3>Полный список посещений с количеством за день</h3>
<p>Вывод: дата / время, логин, страница, общее количество посещений всех страниц пользователем за данный день</p>
<code>
	SELECT UDATE, USER_LOGIN, PAGE_NAME, COUNT(UDATE) as CNT_DAY <br>
	FROM LOG_TAB <br>
	GROUP BY UDATE
</code>

<h2>Module jQuery</h2>
<h3>Вывести в консоль любую информацию на клик по третьему элементу li</h3>
<code>
	$("ul li:nth-child(3)").click(() => { <br>
	console.log('Click'); <br>
	});
</code>
<h3>На клик по любому элементу li вывести его номер в наборе через 5 секунд</h3>
<code>
	$('ul li').on('click', function () { <br>
	setTimeout(() => { <br>
	$( this ).append( $( this ).data('info') ); <br>
	}, 5000); <br>
	});
</code>

<div>
	<ul class="js">
		<li data-info="1">button 1</li>
		<li data-info="2">button 2</li>
		<li data-info="3">button 3</li>
		<li data-info="4">button 4</li>
		<li data-info="5">button 5</li>
	</ul>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
	$("ul.js li:nth-child(3)").click(() => {
		console.log('Click');
	});
	$('ul.js li').on('click', function () {
		setTimeout(() => {
			$( this ).append( $( this ).data('info') );
		}, 5000);
	});
</script>