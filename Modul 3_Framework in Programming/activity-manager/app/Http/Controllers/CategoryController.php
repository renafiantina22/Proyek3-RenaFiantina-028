<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->activities()->exists()) {
            return back()->with(
                'error',
                'Kategori tidak dapat dihapus karena masih digunakan oleh kegiatan.'
            );
        }

        $category->delete();

        return back()->with(
            'success',
            'Kategori berhasil dihapus.'
        );
    }
}