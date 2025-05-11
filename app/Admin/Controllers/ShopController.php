<?php

namespace App\Admin\Controllers;

use App\Models\Shop;
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

		$grid->column('id', __('Id'));
		$grid->column('name', __('Name'));
		$grid->column('address', __('Address'));
		$grid->column('phone_number', __('Phone number'));
		$grid->column('description', __('Description'));
		$grid->column('opening_hours', __('Opening hours'));
		$grid->column('created_at', __('Created at'));
		$grid->column('updated_at', __('Updated at'));

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

		$show->field('id', __('Id'));
		$show->field('name', __('Name'));
		$show->field('address', __('Address'));
		$show->field('phone_number', __('Phone number'));
		$show->field('description', __('Description'));
		$show->field('opening_hours', __('Opening hours'));
		$show->field('created_at', __('Created at'));
		$show->field('updated_at', __('Updated at'));

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

		$form->text('name', __('Name'));
		$form->text('address', __('Address'));
		$form->text('phone_number', __('Phone number'));
		$form->textarea('description', __('Description'));
		$form->text('opening_hours', __('Opening hours'));

		return $form;
	}
}
