<?php

namespace App\Filament\Resources\Categories;

use App\Filament\Resources\Categories\Pages\CreateCategory;
use App\Filament\Resources\Categories\Pages\EditCategory;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Filament\Resources\Categories\Schemas\CategoryForm;
use App\Filament\Resources\Categories\Tables\CategoriesTable;
use App\Models\Category;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CategoryResource extends Resource
{
    protected static ?string $navigationLabel= 'Categorias'; //cambia el nombre de la secicon de categorias en el sidebar
    protected static ?string $label= 'Categoria'; //cambia el nombre del titulo de categorias en el sidebar
    protected static ?string $pluralLabel= 'Categorias'; //cambia el nombre del titulo de categorias en el sidebar
    protected static ?string $slug= 'categorias'; //cambia el la ruta url de categorias 
    protected static string|UnitEnum|null $navigationGroup = 'Administración';

    protected static ?string $model = Category::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $recordTitleAttribute = 'Category';

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema); //formulario
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table); //retorna tablas de category table
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'), //estas son rutas que dan las acciones de crear y editar
            // 'create' => CreateCategory::route('/create'), //osea busca o invoca la urd de create
            // 'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
