<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserController extends AdminController
{
	/**
	 * Title for current resource.
	 *
	 * @var string
	 */
	protected $title = 'User';

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid()
	{
		$grid = new Grid(new User());

		$grid->column('id', 'Id');
		$grid->column('name', '名前');
		$grid->column('email', 'メールアドレス');
		$grid->column('postal_code', '郵便番号');
		$grid->column('address', '住所');
		$grid->column('phone', '電話番号');
		$grid->column('role', '役割');
		$grid->column('created_at', '作成日')->sortable();
		$grid->column('updated_at', '最終更新日')->sortable();
		$grid->filter(function ($filter) {
			$filter->like('name', '名前');
			$filter->like('email', 'メールアドレス');
			$filter->like('postal_code', '郵便番号');
			$filter->like('address', '住所');
			$filter->like('phone', '電話番号');
			$filter->equal('role', '役割')->select(['free' => '無料会員', 'premium' => '有料会員']);
			$filter->between('created_at', '作成日')->datetime();
			$filter->between('updated_at', '最終更新日')->datetime();
		});

		$grid->disableCreateButton();
		$grid->disableExport();
		$grid->actions(function ($actions) {
			$actions->disableDelete();
			$actions->disableEdit();
		});

		return $grid;
	}

	/**
	 * Make a show builder.
	 *
	 * @param mixed $id
	 * @return Show
	 */
	protected function detail($id)
	{
		$show = new Show(User::findOrFail($id));

		$show->field('id', 'Id');
		$show->field('name', '名前');
		$show->field('email', 'メールアドレス');
		$show->field('postal_code', '郵便番号');
		$show->field('address', '住所');
		$show->field('phone', '電話番号');
		$show->field('role', '役割');
		$show->field('created_at', '作成日');
		$show->field('updated_at', '最終更新日');

		return $show;
	}
}
