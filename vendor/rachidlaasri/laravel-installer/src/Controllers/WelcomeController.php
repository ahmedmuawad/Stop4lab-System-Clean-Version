<?php
namespace RachidLaasri\LaravelInstaller\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
class WelcomeController extends Controller
{
	public function welcome()
	{
		return view("vendor.installer.welcome");
	}
	public function check(Request $request)
	{
		\File::put(
			base_path("storage/purchase_code"),
			$request["purchase_code"]
		);
		return redirect("install/requirements");
	}
}
