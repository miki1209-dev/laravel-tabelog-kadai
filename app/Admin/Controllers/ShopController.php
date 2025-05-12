<?php

namespace App\Admin\Controllers;

use App\Models\Shop;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ShopController extends AdminController
{
	/**
	 * Title for current resource.
	 *
	 * @var string
	 */
	protected $title = 'Shop';

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid()
	{
		$grid = new Grid(new Shop());

		$grid->column('id', 'ID');
		$grid->column('name', '店舗名');
		$grid->column('address', '住所');
		$grid->column('phone_number', '電話番号');
		$grid->column('description', '店舗説明');
		$grid->column('opening_hours', '営業時間');
		$grid->column('categories', 'カテゴリ名')->display(function ($categories) {
			return implode(', ', array_column($categories, 'name'));
		});
		$grid->column('file_name', '店舗画像');
		$grid->column('created_at', '作成日')->sortable();
		$grid->column('updated_at', '最終更新日')->sortable();

		$grid->filter(function ($filter) {
			$filter->like('name', '店舗名');
			$filter->like('address', '住所');
			$filter->like('phone_number', '電話番号');
			$filter->like('description', '店舗説明');
			$filter->where(function ($query) {
				$input = request()->get('categories');
				$query->whereHas('categories', function ($query) use ($input) {
					$query->where('name', 'like', "%{$input}%");
				});
			}, 'カテゴリ名');
			$filter->between('opening_hours', '営業時間');
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
		$show = new Show(Shop::findOrFail($id));

		$show->field('id', 'ID');
		$show->field('name', '店舗名');
		$show->field('address', '住所');
		$show->field('phone_number', '電話番号');
		$show->field('description', '店舗説明');
		$show->field('opening_hours', '営業時間');
		$show->field('categories', 'カテゴリ名')->as(function ($categories) {
			return $categories->pluck('name')->join(', ');
		});
		$show->field('created_at', '作成日');
		$show->field('updated_at', '最終更新日');

		return $show;
	}

	/**
	 * Make a form builder.
	 *
	 * @return Form
	 */
	protected function form()
	{
		$form = new Form(new Shop());

		$form->text('name', '店舗名');
		$form->text('address', '住所');
		$form->text('phone_number', '電話番号');
		$form->textarea('description', '店舗説明');
		$form->text('opening_hours', '営業時間');
		// 商品追加時カテゴリを複数選択
		$form->multipleSelect('categories', ' カテゴリ名')->options(Category::pluck('name', 'id')->toArray());
		// 画像アップロードの追加
		$form->image('file_name', '店舗画像')->disk('admin')->move('shops')->uniqueName();

		return $form;
	}
}
