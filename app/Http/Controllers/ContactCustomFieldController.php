<?php

namespace App\Http\Controllers;

use App\Models\ContactCustomField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactCustomFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customFields = ContactCustomField::ordered()->get();
        return view('custom-fields.index', compact('customFields'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('custom-fields.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:contact_custom_fields,name',
            'label' => 'required|string|max:255',
            'type' => 'required|in:text,email,number,date,select,textarea',
            'options' => 'nullable|array',
            'required' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'label', 'type', 'required', 'sort_order']);
        $data['is_active'] = true;

        // Handle options for select fields
        if ($request->type === 'select' && $request->has('options')) {
            $options = array_filter($request->options); // Remove empty values
            $data['options'] = $options;
        }

        $customField = ContactCustomField::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Custom field created successfully!',
                'customField' => $customField
            ]);
        }

        return redirect()->route('custom-fields.index')->with('success', 'Custom field created successfully!');
    }

        /**
     * Display the specified resource.
     */
    public function show(ContactCustomField $custom_field)
    {
        return view('custom-fields.form', compact('custom_field'))->with('mode', 'show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactCustomField $custom_field)
    {
        return view('custom-fields.form', compact('custom_field'))->with('mode', 'edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactCustomField $custom_field)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:contact_custom_fields,name,' . $custom_field->id,
            'label' => 'required|string|max:255',
            'type' => 'required|in:text,email,number,date,select,textarea',
            'options' => 'nullable|array',
            'required' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'label', 'type', 'required', 'sort_order']);

        // Handle options for select fields
        if ($request->type === 'select' && $request->has('options')) {
            $options = array_filter($request->options); // Remove empty values
            $data['options'] = $options;
        } else {
            $data['options'] = null;
        }

        $custom_field->update($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Custom field updated successfully!',
                'customField' => $custom_field
            ]);
        }

        return redirect()->route('custom-fields.index')->with('success', 'Custom field updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactCustomField $custom_field)
    {
        $custom_field->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Custom field deleted successfully!'
            ]);
        }

        return redirect()->route('custom-fields.index')->with('success', 'Custom field deleted successfully!');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(ContactCustomField $custom_field)
    {
        $custom_field->update(['is_active' => !$custom_field->is_active]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'is_active' => $custom_field->is_active
            ]);
        }

        return back()->with('success', 'Status updated successfully!');
    }
}
