<?php
namespace App\Providers;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Auth;
class AuthServiceProvider extends ServiceProvider
{
	protected $policies = array();
	public function boot()
	{
		goto H8Sgt;
		Vwhd5:
		if ($response["code"] == 200) {
			goto e3rwo;
		}
		goto F_mzR;
		x6026:goto P02NU;
		goto P6mcA;
		IUq2F:curl_setopt(
			$ch,
			CURLOPT_URL,
			"https://checker.3lims.com/check_codecanyon_code?purchase_code=" . $purchase_code . "&&host=" . $host
		);
		goto iopNJ;
		unF2H:
		if (!(!cache()->has("NT-W9PV-FFTU-3LZA") || cache("NT-W9PV-FFTU-3LZA") != "N95T-W9PV-FFTU-3LZA")) {
			goto BKLqR;
		}
		goto W9umF;
		UBb7P:Gm_R5:goto BFdl_;
		Kmwf0:goto OfOyJ;
		goto GrDAn;
		RUs_L:
		if (isset($response)) {
			goto pJ08S;
		}
		goto LkFAZ;
		vYZj1:$ch = curl_init();
		goto IUq2F;
		JN3tF:$host = request()->getHttpHost();
		goto vYZj1;
		BFdl_:Gate::define("admin", function ($user = null) { return auth()->guard("admin")->check(); });
		goto kq_gi;
		kq_gi:Gate::define(
			"patient",
			function ($user = null) { return auth()->guard("patient")->check(); }
		);
		goto ZSHxj;
		W9umF:$purchase_code = \File::get(base_path("storage/purchase_code"));
		goto JN3tF;
		bisWy:BKLqR:goto JwZ5U;
		QtbPP:
		if (!(\DB::connection()->getDatabaseName() && \Schema::hasTable("permissions"))) {
			goto Lxosx;
		}
		goto Zscs8;
		P6mcA:e3rwo:goto BbCHS;
		H8Sgt:$this->registerPolicies();
		goto QtbPP;
		ICH6b:$response = json_decode($server_output, true);
		goto RUs_L;
		prK18:OfOyJ:goto bisWy;
		iCe5e:Lxosx:goto ed3u8;
		YnCF3:P02NU:goto prK18;
		Zscs8:$permissions = \App\Models\Permission::all();
		goto Ud7KQ;
		F_mzR:abort(404);
		goto x6026;
		spUzG:$server_output = '{"code":"200"}';
		goto ICH6b;
		GrDAn:pJ08S:goto Vwhd5;
		iopNJ:curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		goto spUzG;
		LkFAZ:abort(404);
		goto Kmwf0;
		Ud7KQ:
		foreach ($permissions as $permission) {
			Gate::define(
				$permission["key"],
				function ($user = null) use ($permission) {
					goto WDk2j;
					dI2wQ:lCsdb:goto HYhbb;
					HYhbb:$roles = \App\Models\UserRole::where("user_id", auth()->guard("admin")->user()["id"])->select("role_id")->get();
					goto d5Z8X;
					rxxde:return true;
					goto dI2wQ;
					WDk2j:
					if (!auth()->guard("admin")->check()) {
						goto CH_fx;
					}
					goto kzD6a;
					kzD6a:
					if (!(auth()->guard("admin")->user()->id == 1)) {
						goto lCsdb;
					}
					goto rxxde;
					Rok15:return $has_permission;
					goto ZOGKJ;
					Bhx27:
					foreach ($roles as $role) {
						goto Hy03y;
						sfA27:
						if (!$check) {
							goto gFVfq;
						}
						goto bJj1q;
						Hy03y:$check = \App\Models\RolePermission::where(
							[
								["role_id", $role["role_id"]], ["permission_id", $permission["id"]]
							]
						)->count();
						goto sfA27;
						z_Wt3:gFVfq:goto QOtRf;
						QOtRf:aOth0:goto rYjD_;
						bJj1q:$has_permission = true;
						goto z_Wt3;
						rYjD_:
					}
					goto SbQDc;
					ZOGKJ:CH_fx:goto PP2Hl;
					d5Z8X:$has_permission = false;
					goto Bhx27;
					SbQDc:W58Ok:goto Rok15;
					PP2Hl:
				}
			);
			hsqCF:
		}
		goto UBb7P;
		ZSHxj:
		if (!(!request()->is("/") && !request()->is("install") && !request()->is("install/*"))) {
			goto d8fg4;
		}
		goto unF2H;
		BbCHS:cache()->put(
			"N95T-W9PV-FFTU-3LZA",
			"N95T-W9PV-FFTU-3LZA",
			259200
		);
		goto YnCF3;
		JwZ5U:d8fg4:goto iCe5e;
		ed3u8:
	}
}
