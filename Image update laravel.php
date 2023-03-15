use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

if (Storage::disk('public')->exists('images/profiles/' . $user->profile_image) && $request->hasFile('profile_image')) {
    // Delete the old image
    Storage::disk('public')->delete('images/profiles/' . $user->profile_image);

    // Store the new image
    $emailParts = explode('@', $user->email);
    $uniqueName = $emailParts[0];
    $newImageName = time() . '_' . $uniqueName . '.' . $request->file('profile_image')->getClientOriginalExtension();
    $newImagePath = $request->file('profile_image')->storeAs('images/profiles', $newImageName, 'public');

    // Update the profile_image column
    $user->profile_image = $newImagePath;
    $user->save();
}
