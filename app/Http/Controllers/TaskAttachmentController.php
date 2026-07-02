<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\TaskAttachment;
class TaskAttachmentController extends Controller
{
    public function destroy($id)
    {
        $attachment = TaskAttachment::findOrFail($id);
        // Delete the file from storage
        Storage::disk('public')->delete($attachment->path);

        // Delete the attachment record from the database
        $attachment->delete();

        return back()->with('success', 'Attachment deleted successfully.');

    }
}
