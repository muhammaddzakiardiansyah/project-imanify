<?php

namespace App\Http\Controllers;

use App\Models\DescriptionItem;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DescriptionItemController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('search')) {
            $descriptionItem = DescriptionItem::with('user')
                ->where('item_name', 'LIKE', "%{$request->query('search')}%")
                ->orWhere('status', 'LIKE', "%{$request->query('search')}%")
                ->orWhere('date', 'LIKE', "%{$request->query('search')}%")
                ->orWhere('source_of_found', 'LIKE', "%{$request->query('search')}%")
                ->paginate(10);
        } else {
            $descriptionItem = DescriptionItem::with('user')->paginate(10);
        }
        return view(
            'dashboard.description-items.index',
            [
                'descriptionItems' => $descriptionItem,
                'page_title' => 'Description Items',
                'url' => 'dashboard/description-items',
                'active' => 'description-items',
            ]
        );
    }

    public function showCreateDescriptionItem()
    {
        return view(
            'dashboard.description-items.create',
            [
                'page_title' => 'Create Description Items',
                'url' => 'dashboard/description-items/create',
                'active' => 'description-items',
            ]
        );
    }

    public function createDescriptionItem(Request $request)
    {
        $rules = $request->validate([
            'item_name' => ['required', 'min:3', 'max:20'],
            'amount' => ['required', 'numeric'],
            'status' => ['required'],
            'date' => ['required', 'date'],
            'source_of_found' => ['required'],
        ]);

        $rules['user_id'] = Auth::user()->id;

        try {
            DescriptionItem::create($rules);

            return redirect('/dashboard/description-items')->with(
                'message',
                'Success created description item'
            );
        } catch (QueryException $e) {
            return back()->with('message', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            return back()->with('message', 'Error : ' . $e->getMessage());
        }
    }

    public function showEditDescriptionItem(string $id)
    {
        $descriptionItem = DescriptionItem::find($id);

        return view(
            'dashboard.description-items.edit',
            [
                'descriptionItem' => $descriptionItem,
                'page_title' => 'Edit Description Items',
                'url' => 'dashboard/description-items/edit',
                'active' => 'description-items',
            ]
        );
    }

    public function editDescriptionItem(Request $request, string $id)
    {
        $rules = $request->validate([
            'item_name' => ['required', 'min:3', 'max:20'],
            'amount' => ['required', 'numeric'],
            'status' => ['required'],
            'date' => ['required', 'date'],
            'source_of_found' => ['required'],
        ]);

        $rules['user_id'] = Auth::user()->id;

        $item = DescriptionItem::findOrFail($id);
        $item->update($rules);
        return redirect('/dashboard/description-items')->with('message', 'Success edited description item');
    }

    public function deleteDescriptionItem(string $id)
    {
        $descriptionItem = DescriptionItem::find($id);
        if ($descriptionItem) {
            $descriptionItem->destroy($id);
            return redirect('/dashboard/description-items')->with('message', 'Success deleted description item');
        } else {
            return back()->with('message', 'Failed deleting description item');
        }
    }

    public function handleViewPDF(): void
    {
        $mpdf = new \Mpdf\Mpdf();

        $descriptionItems = DescriptionItem::orderBy('date', 'asc')->get();

        $mpdf->WriteHTML(view(
            'components.description-items-pdf',
            [
                'descriptionItems' => $descriptionItems,
                'page_title' => 'Create PDF Description Items',
            ]
        ));
        $mpdf->Output();
    }

    public function handleDownloadPDF(): void
    {
        $mpdf = new \Mpdf\Mpdf();

        $descriptionItems = DescriptionItem::orderBy('date', 'asc')->get();

        $mpdf->WriteHTML(view(
            'components.description-items-pdf',
            [
                'descriptionItems' => $descriptionItems,
                'page_title' => 'Create PDF Description Items',
            ]
        ));
        $mpdf->Output('inventaris-barang-masuk-barang-keluar.pdf', 'D');
    }
}
