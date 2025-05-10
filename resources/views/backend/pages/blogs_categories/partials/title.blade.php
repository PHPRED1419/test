@if (Route::is('admin.blogs_categories.index'))
Blogs Categories 
@elseif(Route::is('admin.blogs_categories.create'))
Create New Blogs Categories
@elseif(Route::is('admin.blogs_categories.edit'))
Edit Category {{ $category->category_name }}
@elseif(Route::is('admin.blogs_categories.show'))
View Category {{ $category->category_name }}
@endif
| Admin Panel - 
{{ config('app.name') }}