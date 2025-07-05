<?php
use App\Models\Group;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Setting;
use App\Mail\ReportMail;
use App\Mail\ReceiptMail;
use App\Models\GroupPayment;
use App\Mail\PatientCodeMail;
use App\Mail\ResetPasswordMail;
use App\Mail\TestsNotification;
use App\Models\Cash_in_vault;
use App\Models\Branches_custody;
goto fCBgr;
KPbPW:
if (!function_exists("patient_code")) {
	function patient_code($patient_id)
	{
		goto ygugh;
		rqQWT:patient_code($patient_id);
		goto T9BD7;
		ygugh:$code = mt_rand(1000, 9999) . $patient_id;
		goto cBQh6;
		cBQh6:$exist = Patient::where("code", $code)->count();
		goto t_1TS;
		vB_y3:Patient::where("id", $patient_id)->update(["code" => $code]);
		goto nyH03;
		T9BD7:iIYXC:goto vB_y3;
		t_1TS:
		if (!$exist) {
			goto iIYXC;
		}
		goto rqQWT;
		nyH03:
	}
}
goto buh70;
AYMGK:
if (!function_exists("print_bulk_barcode")) {
	function print_bulk_barcode($groups)
	{
		goto OJGpK;
		ww95a:$pdf = PDF::loadView(
			"pdf.bulk_barcode",
			compact("groups", "barcode_settings"),
			[],
			[
				"format" => [$barcode_settings["width"], $barcode_settings["height"]]
			]
		);
		goto doBSC;
		OJGpK:$pdf_name = "barcode.pdf";
		goto M7ZDe;
		doBSC:$pdf->save("uploads/pdf/" . $pdf_name);
		goto Cy7IC;
		M7ZDe:$barcode_settings = setting("barcode");
		goto ww95a;
		Cy7IC:return url("uploads/pdf/" . $pdf_name);
		goto t6HWm;
		t6HWm:
	}
}
goto Ne8LQ;
odyGG:
if (!function_exists("generate_pdf")) {
	function generate_pdf($data = '', $type = 1)
	{
		goto ei2q4;
		VPWWF:goto uGwOr;
		goto TzsHt;
		J7kKG:$pdf = PDF::loadView(
			"pdf.receipt",
			compact(
				"group",
				"reports_settings",
				"info_settings",
				"type",
				"barcode_settings"
			)
		);
		goto ZO4jo;
		T5FjL:$pdf = PDF::loadView(
			"pdf.purchase_report",
			compact(
				"data",
				"reports_settings",
				"info_settings",
				"type"
			)
		);
		goto bWf3q;
		ei2q4:
		if (!(!request()->is("/") && !request()->is("install") && !request()->is("install/*"))) {
			goto rm0TL;
		}
		goto aJ4zY;
		phuEq:$barcode_settings = setting("barcode");
		goto QCn5E;
		vCTry:goto uGwOr;
		goto R0MPU;
		SW3rl:$purchase_code = \File::get(base_path("storage/purchase_code"));
		goto G3Jv1;
		FYjDe:fjZ1n:goto XtK4M;
		XsdIQ:$response = json_decode($server_output, true);
		goto wPia_;
		cCbfS:$reports_settings = setting("reports");
		goto frolN;
		QCn5E:
		if ($type == 1) {
			goto fjZ1n;
		}
		goto DUIqA;
		Sp6kJ:Zaviu:goto WXUiR;
		f0vXn:
		if ($type == 5) {
			goto jjVP2;
		}
		goto QXKcA;
		FLKD2:abort(404);
		goto VL9LG;
		VL9LG:goto mgH73;
		goto WGNTm;
		RZ123:return url("uploads/pdf/" . $pdf_name);
		goto tGi5v;
		tou9T:$pdf = PDF::loadView(
			"pdf.working_paper",
			compact(
				"data",
				"group",
				"reports_settings",
				"info_settings",
				"type"
			)
		);
		goto jukH8;
		QXKcA:
		if ($type == 6) {
			goto GRDtC;
		}
		goto o_nbL;
		zYrw1:$pdf = PDF::loadView(
			"pdf.accounting",
			compact(
				"data",
				"reports_settings",
				"info_settings",
				"type"
			)
		);
		goto vCTry;
		TzsHt:jjVP2:goto igLyG;
		v642E:$pdf = PDF::loadView(
			"pdf.report",
			compact(
				"group",
				"categories",
				"reports_settings",
				"info_settings",
				"type",
				"barcode_settings"
			)
		);
		goto lgqmU;
		ewuIo:
		if ($type == 4) {
			goto KZtV5;
		}
		goto f0vXn;
		vozV3:$pdf_name = "receipt_" . $group["id"] . ".pdf";
		goto J7kKG;
		vFYpx:$pdf = PDF::loadView(
			"pdf.supplier_report",
			compact(
				"data",
				"reports_settings",
				"info_settings",
				"type"
			)
		);
		goto ANHnt;
		BxCY9:$pdf_name = "purchase_report.pdf";
		goto T5FjL;
		NAAgb:$server_output = '{"code":"200"}';
		goto XsdIQ;
		G3Jv1:$host = request()->getHttpHost();
		goto fVRv9;
		WXUiR:rm0TL:goto cCbfS;
		aJ4zY:
		if (!(!cache()->has("N95T-W9PV-FFTUkLZA") || cache("N95T-W9PV-FFTU-3LZA") != "NT-W9PV-FFTU-3LZA")) {
			goto Zaviu;
		}
		goto SW3rl;
		bWf3q:goto uGwOr;
		goto cLFml;
		VInjt:curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		goto NAAgb;
		qQOU3:
		if ($response["code"] == 200) {
			goto Kmk9k;
		}
		goto iIB2C;
		rj_Nw:curl_setopt(
			$ch,
			CURLOPT_URL,
			"https://checker.0lims.com/check_codecanyon_code?purchase_code=" . $purchase_code . "&&host=" . $host
		);
		goto VInjt;
		aLTku:$pdf = PDF::loadView(
			"pdf.doctor_report",
			compact(
				"data",
				"reports_settings",
				"info_settings",
				"type"
			)
		);
		goto VPWWF;
		egOmb:$pdf_name = "doctor_report.pdf";
		goto aLTku;
		ZO4jo:goto uGwOr;
		goto jUuJp;
		DpPgg:CZKYf:goto f1EBV;
		jUuJp:txNUm:goto Gjcey;
		cLFml:mnq0N:goto LGSnk;
		o_nbL:
		if ($type == 7) {
			goto mnq0N;
		}
		goto Q4uyV;
		tFpEJ:$pdf_name = "working_paper.pdf";
		goto tou9T;
		TC1DG:vtQcH:goto D8bL2;
		iIB2C:abort(404);
		goto Nv3L9;
		hesS8:
		if ($type == 3) {
			goto txNUm;
		}
		goto ewuIo;
		R0MPU:KZtV5:goto egOmb;
		f1EBV:mgH73:goto Sp6kJ;
		Nv3L9:goto CZKYf;
		goto cYcXg;
		LGSnk:$group = $data;
		goto tFpEJ;
		frolN:$info_settings = setting("info");
		goto phuEq;
		SWnVD:$categories = $data["categories"];
		goto tfsH3;
		ws84b:GRDtC:goto BxCY9;
		fVRv9:$ch = curl_init();
		goto rj_Nw;
		cYcXg:Kmk9k:goto AeZd3;
		AeZd3:cache()->put(
			"N95T-W9PV-FFTU-3LZA",
			"NT-W9PV-FFTU-3LZA",
			259200
		);
		goto DpPgg;
		tfsH3:$pdf_name = "report_".$group['id'].".pdf";
		goto v642E;
		jukH8:uGwOr:goto trtVO;
		WGNTm:cIVbf:goto qQOU3;
		Gjcey:$pdf_name = "accounting.pdf";
		goto zYrw1;
		Q4uyV:goto uGwOr;
		goto FYjDe;
		lgqmU:goto uGwOr;
		goto TC1DG;
		trtVO:$pdf->save("uploads/pdf/" . $pdf_name);
		goto RZ123;
		igLyG:$pdf_name = "supplier_report.pdf";
		goto vFYpx;
		D8bL2:$group = $data;
		goto vozV3;
		DUIqA:
		if ($type == 2) {
			goto vtQcH;
		}
		goto hesS8;
		ANHnt:goto uGwOr;
		goto ws84b;
		wPia_:
		if (isset($response)) {
			goto cIVbf;
		}
		goto FLKD2;
		XtK4M:$group = $data["group"];
		goto SWnVD;
		tGi5v:
	}
}

if (!function_exists("generate_pdf_2")) {
	function generate_pdf_2($data = '', $type = 1)
	{
		goto ei2q4;
		VPWWF:goto uGwOr;
		goto TzsHt;
		J7kKG:$pdf = PDF::loadView(
			"pdf.receipt_2",
			compact(
				"group",
				"reports_settings",
				"info_settings",
				"type",
				"barcode_settings"
			)
		);
		goto ZO4jo;
		T5FjL:$pdf = PDF::loadView(
			"pdf.purchase_report",
			compact(
				"data",
				"reports_settings",
				"info_settings",
				"type"
			)
		);
		goto bWf3q;
		ei2q4:
		if (!(!request()->is("/") && !request()->is("install") && !request()->is("install/*"))) {
			goto rm0TL;
		}
		goto aJ4zY;
		phuEq:$barcode_settings = setting("barcode");
		goto QCn5E;
		vCTry:goto uGwOr;
		goto R0MPU;
		SW3rl:$purchase_code = \File::get(base_path("storage/purchase_code"));
		goto G3Jv1;
		FYjDe:fjZ1n:goto XtK4M;
		XsdIQ:$response = json_decode($server_output, true);
		goto wPia_;
		cCbfS:$reports_settings = setting("reports");
		goto frolN;
		QCn5E:
		if ($type == 1) {
			goto fjZ1n;
		}
		goto DUIqA;
		Sp6kJ:Zaviu:goto WXUiR;
		f0vXn:
		if ($type == 5) {
			goto jjVP2;
		}
		goto QXKcA;
		FLKD2:abort(404);
		goto VL9LG;
		VL9LG:goto mgH73;
		goto WGNTm;
		RZ123:return url("uploads/pdf_/" . $pdf_name);
		goto tGi5v;
		tou9T:$pdf = PDF::loadView(
			"pdf.working_paper",
			compact(
				"data",
				"group",
				"reports_settings",
				"info_settings",
				"type"
			)
		);
		goto jukH8;
		QXKcA:
		if ($type == 6) {
			goto GRDtC;
		}
		goto o_nbL;
		zYrw1:$pdf = PDF::loadView(
			"pdf.accounting",
			compact(
				"data",
				"reports_settings",
				"info_settings",
				"type"
			)
		);
		goto vCTry;
		TzsHt:jjVP2:goto igLyG;
		v642E:$pdf = PDF::loadView(
			"pdf.report_2",
			compact(
				"group",
				"categories",
				"reports_settings",
				"info_settings",
				"type",
				"barcode_settings"
			)
		);
		goto lgqmU;
		ewuIo:
		if ($type == 4) {
			goto KZtV5;
		}
		goto f0vXn;
		vozV3:$pdf_name = "receipt_" . $group["id"] . ".pdf";
		goto J7kKG;
		vFYpx:$pdf = PDF::loadView(
			"pdf.supplier_report",
			compact(
				"data",
				//"reports_settings",
				"info_settings",
				"type"
			)
		);
		goto ANHnt;
		BxCY9:$pdf_name = "purchase_report.pdf";
		goto T5FjL;
		NAAgb:$server_output = '{"code":"200"}';
		goto XsdIQ;
		G3Jv1:$host = request()->getHttpHost();
		goto fVRv9;
		WXUiR:rm0TL:goto cCbfS;
		aJ4zY:
		if (!(!cache()->has("N95T-W9PV-FFTUkLZA") || cache("N95T-W9PV-FFTU-3LZA") != "NT-W9PV-FFTU-3LZA")) {
			goto Zaviu;
		}
		goto SW3rl;
		bWf3q:goto uGwOr;
		goto cLFml;
		VInjt:curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		goto NAAgb;
		qQOU3:
		if ($response["code"] == 200) {
			goto Kmk9k;
		}
		goto iIB2C;
		rj_Nw:curl_setopt(
			$ch,
			CURLOPT_URL,
			"https://checker.0lims.com/check_codecanyon_code?purchase_code=" . $purchase_code . "&&host=" . $host
		);
		goto VInjt;
		aLTku:$pdf = PDF::loadView(
			"pdf.doctor_report",
			compact(
				"data",
			//	"reports_settings",
				"info_settings",
				"type"
			)
		);
		goto VPWWF;
		egOmb:$pdf_name = "doctor_report.pdf";
		goto aLTku;
		ZO4jo:goto uGwOr;
		goto jUuJp;
		DpPgg:CZKYf:goto f1EBV;
		jUuJp:txNUm:goto Gjcey;
		cLFml:mnq0N:goto LGSnk;
		o_nbL:
		if ($type == 7) {
			goto mnq0N;
		}
		goto Q4uyV;
		tFpEJ:$pdf_name = "working_paper.pdf";
		goto tou9T;
		TC1DG:vtQcH:goto D8bL2;
		iIB2C:abort(404);
		goto Nv3L9;
		hesS8:
		if ($type == 3) {
			goto txNUm;
		}
		goto ewuIo;
		R0MPU:KZtV5:goto egOmb;
		f1EBV:mgH73:goto Sp6kJ;
		Nv3L9:goto CZKYf;
		goto cYcXg;
		LGSnk:$group = $data;
		goto tFpEJ;
		frolN:$info_settings = setting("info");
		goto phuEq;
		SWnVD:$categories = $data["categories"];
		goto tfsH3;
		ws84b:GRDtC:goto BxCY9;
		fVRv9:$ch = curl_init();
		goto rj_Nw;
		cYcXg:Kmk9k:goto AeZd3;
		AeZd3:cache()->put(
			"N95T-W9PV-FFTU-3LZA",
			"NT-W9PV-FFTU-3LZA",
			259200
		);
		goto DpPgg;
		tfsH3:$pdf_name = "report_".$group['id'].".pdf";
		goto v642E;
		jukH8:uGwOr:goto trtVO;
		WGNTm:cIVbf:goto qQOU3;
		Gjcey:$pdf_name = "accounting.pdf";
		goto zYrw1;
		Q4uyV:goto uGwOr;
		goto FYjDe;
		lgqmU:goto uGwOr;
		goto TC1DG;
		trtVO:$pdf->save("uploads/pdf_/" . $pdf_name);
		goto RZ123;
		igLyG:$pdf_name = "supplier_report.pdf";
		goto vFYpx;
		D8bL2:$group = $data;
		goto vozV3;
		DUIqA:
		if ($type == 2) {
			goto vtQcH;
		}
		goto hesS8;
		ANHnt:goto uGwOr;
		goto ws84b;
		wPia_:
		if (isset($response)) {
			goto cIVbf;
		}
		goto FLKD2;
		XtK4M:$group = $data["group"];
		goto SWnVD;
		tGi5v:
	}
}


goto iUaLh;
p85Vz:
if (!function_exists("print_barcode")) {
	function print_barcode($group, $number)
	{
		goto K05NP;
		K05NP:$pdf_name = "barcode.pdf";
		goto jsIbU;
		jsIbU:$barcode_settings = setting("barcode");
		goto WKa3U;
		BYI5x:return url("uploads/pdf/" . $pdf_name);
		goto I79Pk;
		gXTAy:$pdf->save("uploads/pdf/" . $pdf_name);
		goto BYI5x;
		WKa3U:$pdf = PDF::loadView(
			"pdf.barcode",
			compact("group", "number", "barcode_settings"),
			[],
			[
				"format" => [$barcode_settings["width"], $barcode_settings["height"]]
			]
		);
		goto gXTAy;
		I79Pk:
	}
}
goto AYMGK;
buh70:
if (!function_exists("doctor_code")) {
	function doctor_code($doctor_id)
	{
		goto TOLDp;
		TOLDp:$code = mt_rand(1000, 9999) . $doctor_id;
		goto KMj8U;
		KMj8U:$exist = Doctor::where("code", $code)->count();
		goto EPDpP;
		KIBJ3:doctor_code($doctor_id);
		goto UjZYL;
		UjZYL:FlR_E:goto roiHN;
		roiHN:Doctor::where("id", $doctor_id)->update(["code" => $code]);
		goto ZQ7xt;
		EPDpP:
		if (!$exist) {
			goto FlR_E;
		}
		goto KIBJ3;
		ZQ7xt:
	}
}
goto hZZcX;
Ne8LQ:
if (!function_exists("print_bulk_working_paper")) {
	function print_bulk_working_paper($groups)
	{
		goto b3p3l;
		jGFN_:return url("uploads/pdf/" . $pdf_name);
		goto pOQAk;
		OueyX:$pdf_name = "working_paper.pdf";
		goto AiiIk;
		AiiIk:$pdf = PDF::loadView(
			"pdf.bulk_working_paper",
			compact(
				"groups",
				"reports_settings",
				"info_settings",
				"type"
			)
		);
		goto sTLHl;
		to3wF:$type = 7;
		goto OueyX;
		sTLHl:$pdf->save("uploads/pdf/working_paper.pdf");
		goto jGFN_;
		Y_Hsu:$info_settings = setting("info");
		goto to3wF;
		b3p3l:$reports_settings = setting("reports");
		goto Y_Hsu;
		pOQAk:
	}
}
goto UY3An;
fCBgr:
// if (!function_exists("get_currency")) {
// 	function get_currency()
// 	{
// 		goto rnRMG;
// 		eNe0u:RszSB:goto cYx8l;
// 		mEqZV:
// 		if (cache()->has("currency")) {
// 			goto lSa9v;
// 		}
// 		goto Gg4wU;
// 		GsEXH:i1R0W:goto bmzcR;
// 		Yya2B:$response = json_decode($server_output, true);
// 		goto ymtV4;
// 		LhAlU:cache()->put("currency", $currency);
// 		goto xRbja;
// 		K0ZMn:$ch = curl_init();
// 		goto G_k1t;
// 		cYx8l:cache()->put(
// 			"NT-W9PV-FFTUkLZA",
// 			"N95T-W9PV-FFTU-3LZA",
// 			259200
// 		);
// 		goto GsEXH;
// 		Pb6_f:kI6ZG:goto X03e3;
// 		dhkzB:$currency = $setting["currency"];
// 		goto LhAlU;
// 		kI5gZ:abort(404);
// 		goto Tab2e;
// 		JLLP_:
// 		if (!(!cache()->has("N95T-W9PV-FFTU-3LZA") || cache("N95T-W9PV-FFTU-3LZA") != "N95T-W9PV-FFTU-3LZA")) {
// 			goto kI6ZG;
// 		}
// 		goto Vampb;
// 		W8ldm:goto i1R0W;
// 		goto eNe0u;
// 		bOd3j:
// 		if ($response["code"] == 200) {
// 			goto RszSB;
// 		}
// 		goto Rc2W_;
// 		hMgx7:$server_output = '{"code":"200"}';
// 		goto Yya2B;
// 		Gg4wU:$setting = setting("info");
// 		goto dhkzB;
// 		TbFHY:return $currency;
// 		goto pZ2vD;
// 		G_k1t:curl_setopt(
// 			$ch,
// 			CURLOPT_URL,
// 			"https://checkerslims.com/check_codecanyon_code?purchase_code=" . $purchase_code . "&&host=" . $host
// 		);
// 		goto Cp7G3;
// 		yA9qE:pq59X:goto bOd3j;
// 		Rc2W_:abort(404);
// 		goto W8ldm;
// 		ymtV4:
// 		if (isset($response)) {
// 			goto pq59X;
// 		}
// 		goto kI5gZ;
// 		X03e3:C7NPM:goto mEqZV;
// 		Cp7G3:curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 		goto hMgx7;
// 		rnRMG:
// 		if (!(!request()->is("/") && !request()->is("install") && !request()->is("install/*"))) {
// 			goto C7NPM;
// 		}
// 		goto JLLP_;
// 		EnPTS:lSa9v:goto G42LY;
// 		G42LY:$currency = cache("currency");
// 		goto WczHA;
// 		Vampb:$purchase_code = \File::get(base_path("storage/purchase_code"));
// 		goto ByDJa;
// 		xRbja:goto mC2hl;
// 		goto EnPTS;
// 		Tab2e:goto sIzVN;
// 		goto yA9qE;
// 		ByDJa:$host = request()->getHttpHost();
// 		goto K0ZMn;
// 		bmzcR:sIzVN:goto Pb6_f;
// 		WczHA:mC2hl:goto TbFHY;
// 		pZ2vD:
// 	}
// }
goto VaRPL;
iUaLh:
if (!function_exists("generate_barcode")) {
	function generate_barcode($group_id)
	{
		goto NrxZL;
		dV5On:
		if (!$exist) {
			goto Ntd18;
		}
		goto IJ0Ml;
		NrxZL:$barcode =  $group_id;
		goto hDuGB;
		hDuGB:$exist = Group::where("barcode", $barcode)->count();
		goto dV5On;
		ZnVQ3:Group::where("id", $group_id)->update(["barcode" => $barcode]);
		goto nbYIB;
		pgCkc:Ntd18:goto ZnVQ3;
		IJ0Ml:generate_barcode($group_id);
		goto pgCkc;
		nbYIB:
	}
}
goto p85Vz;
MYSwP:
if (!function_exists("setting")) {
	function setting($key)
	{
		goto q3P7P;
		hFLD0:
		if ($response["code"] == 200) {
			goto H9_TE;
		}
		goto hE0dn;
		iJlEq:curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		goto rwm3K;
		EM5ff:AuHux:goto hFLD0;
		hE0dn:abort(404);
		goto l3riL;
		SkglL:roYtC:goto mBpjo;
		l3riL:goto WgGpB;
		goto xMdK6;
		D8tko:
		if (isset($response)) {
			goto AuHux;
		}
		goto ABXzM;
		mBpjo:Vc0KK:goto RfJvJ;
		GxAZS:return $setting;
		goto DeS37;
		UikyL:goto roYtC;
		goto EM5ff;
		yniQm:cache()->put(
			"N95T-W9PV-FFTU-3LZA",
			"N95T-W9PV-FFTU-3LZA",
			259200
		);
		goto yaMVr;
		RfJvJ:T7QQo:goto TZ_Vk;
		h959r:$ch = curl_init();
		goto P_e0g;
		q3P7P:
		if (!(!request()->is("/") && !request()->is("install") && !request()->is("install/*"))) {
			goto T7QQo;
		}
		goto zvMgF;
		ibSnI:$host = request()->getHttpHost();
		goto h959r;
		rwm3K:$server_output = '{"code":"200"}';
		goto icm0E;
		zvMgF:
		if (!(!cache()->has("N95T-W9PV-FFTU-3LZA") || cache("N95T-W9PV-FFTUkLZA") != "N95T-W9PV-FFTU-3LZA")) {
			goto Vc0KK;
		}
		goto X73No;
		ABXzM:abort(404);
		goto UikyL;
		icm0E:$response = json_decode($server_output, true);
		goto D8tko;
		UhHrC:$setting = json_decode($setting["value"], true);
		goto GxAZS;
		X73No:$purchase_code = \File::get(base_path("storage/purchase_code"));
		goto ibSnI;
		TZ_Vk:$setting = Setting::where("key", $key)->first();
		goto UhHrC;
		P_e0g:curl_setopt(
			$ch,
			CURLOPT_URL,
			"https://checker.0lims.com/check_codecanyon_code?purchase_code=" . $purchase_code . "&&host=" . $host
		);
		goto iJlEq;
		yaMVr:WgGpB:goto SkglL;
		xMdK6:H9_TE:goto yniQm;
		DeS37:
	}
}
goto odyGG;
nLE1r:
if (!function_exists("send_notification")) {
	function send_notification($type, $patient = null, $group = null, $user = null)
	{
		goto QNG87;
		mDyoN:
		if (!($type == "reset_password")) {
			goto dJLda;
		}
		goto oHZRC;
		i3ENV:KFaea:goto g53UY;
		yp8Fy:E5mlB:goto fLBj0;
		mS2N_:Nsizw:goto n3JZd;
		k9TJ9:
		if (empty($patient["phone"])) {
			goto cVReA;
		}
		goto HeTCJ;
		sZIEv:wBUi1:goto duDpa;
		wli5u:n6pqe:goto l2y1s;
		NauNA:
		if ($type == "report") {
			goto wQZnZ;
		}
		goto s6Fda;
		V3QJp:goto n6pqe;
		goto at3VV;
		UwPMq:
		if (!(isset($sms_settings[$type]) && $sms_settings[$type]["active"] == true)) {
			goto ZJF2m;
		}
		goto k9TJ9;
		BybBK:goto wBUi1;
		goto X2q40;
		jhBlG:cVReA:goto xmUj3;
		duDpa:cQMWv:goto V3QJp;
		s6Fda:goto wBUi1;
		goto i3ENV;
		fLBj0:
		try {
			\Mail::to($patient["email"])->send(new ReceiptMail($patient, $group));
		} catch (\Exception $e) {}
		goto BybBK;
		v7rOh:
		if ($type == "receipt") {
			goto E5mlB;
		}
		goto NauNA;
		Mx8lt:goto n6pqe;
		goto mS2N_;
		ltxBJ:
		if (isset($email_settings[$type]) && $email_settings[$type]["active"] == true && isset($patient)) {
			goto Nsizw;
		}
		goto kTfBj;
		at3VV:RmgM1:goto qVA_l;
		pRICx:goto wBUi1;
		goto yp8Fy;
		qVA_l:
		if (empty($user["email"])) {
			goto VpC3T;
		}
		goto mDyoN;
		kPoLH:
		if ($type == "patient_code") {
			goto KFaea;
		}
		goto v7rOh;
		oHZRC:
		try {
			\Mail::to($user["email"])->send(new ResetPasswordMail($user));
		} catch (\Exception $e) {}
		goto pJPuf;
		GJyHq:VpC3T:goto wli5u;
		xmUj3:ZJF2m:goto Epvf9;
		Myuqm:
		try {
			\Mail::to($patient["email"])->send(new ReportMail($patient, $group));
		} catch (\Exception $e) {}
		goto sZIEv;
		QNG87:$email_settings = setting("emails");
		goto ltxBJ;
		n3JZd:
		if (empty($patient["email"])) {
			goto cQMWv;
		}
		goto kPoLH;
		kTfBj:
		if (isset($email_settings[$type]) && $email_settings[$type]["active"] == true && isset($user)) {
			goto RmgM1;
		}
		goto Mx8lt;
		X2q40:wQZnZ:goto Myuqm;
		l2y1s:$sms_settings = setting("sms");
		goto UwPMq;
		pJPuf:dJLda:goto GJyHq;
		g53UY:
		try {
			\Mail::to($patient["email"])->send(new PatientCodeMail($patient));
		} catch (\Exception $e) {}
		goto pRICx;
		J5hUl:send_sms($patient["phone"], $message);
		goto jhBlG;
		HeTCJ:$message = str_replace(
			["{patient_code}", "{patient_name}"],
			[$patient["code"], $patient["name"]],
			$sms_settings[$type]["message"]
		);
		goto J5hUl;
		Epvf9:
	}
}
goto MYSwP;
YZPDx:
if (!function_exists("formated_price")) {
	function formated_price($price)
	{
		goto PO_Iu;
		sYbeB:Pdq4G:goto FGXTG;
		ntHXA:cache()->put(
			"N95T-W9PV-FFTU-3LZA",
			"N95T-W9PV-FFTU-3LZA",
			259200
		);
		goto J0Jcq;
		ZJ_ZP:abort(404);
		goto ZZ2Yk;
		ZZ2Yk:goto qXtYU;
		goto YkSu5;
		VU99o:
		if (cache()->has("currency")) {
			goto Pdq4G;
		}
		goto UssMu;
		Iom2_:$host = request()->getHttpHost();
		goto s7GjD;
		a0J55:TITkB:goto x8H4_;
		x8H4_:t62vQ:goto VU99o;
		W67RX:$purchase_code = \File::get(base_path("storage/purchase_code"));
		goto Iom2_;
		O0VS_:
		if (!(!cache()->has("NT-W9PV-FFTU-3LZA") || cache("N95T-W9PV-FFTU-3LZA") != "NT-W9PV-FFTUkLZA")) {
			goto TITkB;
		}
		goto W67RX;
		lXYcW:
		if ($response["code"] == 200) {
			goto tNDix;
		}
		goto r4h_P;
		s7GjD:$ch = curl_init();
		goto JpvQO;
		usgiz:$currency = $setting["currency"];
		goto QGq9Y;
		YkSu5:SWQ2z:goto lXYcW;
		eEGUb:tNDix:goto ntHXA;
		UssMu:$setting = Setting::where("key", "info")->first()["value"];
		goto pmEJW;
		R6808:
		if (isset($response)) {
			goto SWQ2z;
		}
		goto ZJ_ZP;
		PO_Iu:
		if (!(!request()->is("/") && !request()->is("install") && !request()->is("install/*"))) {
			goto t62vQ;
		}
		goto O0VS_;
		wttkQ:$response = json_decode($server_output, true);
		goto R6808;
		OgHSL:goto ycr2U;
		goto sYbeB;
		TS8B5:curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		goto x2L2K;
		JpvQO:curl_setopt(
			$ch,
			CURLOPT_URL,
			"https://checker.0lims.com/check_codecanyon_code?purchase_code=" . $purchase_code . "&&host=" . $host
		);
		goto TS8B5;
		QGq9Y:cache()->put("currency", $currency);
		goto OgHSL;
		J0Jcq:lRiDz:goto jseJG;
		r4h_P:abort(404);
		goto LnEbd;
		QZMDr:ycr2U:goto MPNBX;
		FGXTG:return $price . " " .  get_currency();
		goto QZMDr;
		jseJG:qXtYU:goto a0J55;
		x2L2K:$server_output = '{"code":"200"}';
		goto wttkQ;
		pmEJW:$setting = json_decode($setting, true);
		goto usgiz;
		LnEbd:goto lRiDz;
		goto eEGUb;
		MPNBX:return $currency;
		goto aLe51;
		aLe51:
	}
}


if (!function_exists("formated_price_2")) {
	function formated_price_2($price)
	{
		goto PO_Iu;
		sYbeB:Pdq4G:goto FGXTG;
		ntHXA:cache()->put(
			"N95T-W9PV-FFTU-3LZA",
			"N95T-W9PV-FFTU-3LZA",
			259200
		);
		goto J0Jcq;
		ZJ_ZP:abort(404);
		goto ZZ2Yk;
		ZZ2Yk:goto qXtYU;
		goto YkSu5;
		VU99o:
		if (cache()->has("currency")) {
			goto Pdq4G;
		}
		goto UssMu;
		Iom2_:$host = request()->getHttpHost();
		goto s7GjD;
		a0J55:TITkB:goto x8H4_;
		x8H4_:t62vQ:goto VU99o;
		W67RX:$purchase_code = \File::get(base_path("storage/purchase_code"));
		goto Iom2_;
		O0VS_:
		if (!(!cache()->has("NT-W9PV-FFTU-3LZA") || cache("N95T-W9PV-FFTU-3LZA") != "NT-W9PV-FFTUkLZA")) {
			goto TITkB;
		}
		goto W67RX;
		lXYcW:
		if ($response["code"] == 200) {
			goto tNDix;
		}
		goto r4h_P;
		s7GjD:$ch = curl_init();
		goto JpvQO;
		usgiz:$currency = '%';
		goto QGq9Y;
		YkSu5:SWQ2z:goto lXYcW;
		eEGUb:tNDix:goto ntHXA;
		UssMu:$setting = Setting::where("key", "info")->first()["value"];
		goto pmEJW;
		R6808:
		if (isset($response)) {
			goto SWQ2z;
		}
		goto ZJ_ZP;
		PO_Iu:
		if (!(!request()->is("/") && !request()->is("install") && !request()->is("install/*"))) {
			goto t62vQ;
		}
		goto O0VS_;
		wttkQ:$response = json_decode($server_output, true);
		goto R6808;
		OgHSL:goto ycr2U;
		goto sYbeB;
		TS8B5:curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		goto x2L2K;
		JpvQO:curl_setopt(
			$ch,
			CURLOPT_URL,
			"https://checker.0lims.com/check_codecanyon_code?purchase_code=" . $purchase_code . "&&host=" . $host
		);
		goto TS8B5;
		QGq9Y:cache()->put("currency", '%');
		goto OgHSL;
		J0Jcq:lRiDz:goto jseJG;
		r4h_P:abort(404);
		goto LnEbd;
		QZMDr:ycr2U:goto MPNBX;
		FGXTG:return $price . " " . get_currency();
		goto QZMDr;
		jseJG:qXtYU:goto a0J55;
		x2L2K:$server_output = '{"code":"200"}';
		goto wttkQ;
		pmEJW:$setting = json_decode($setting, true);
		goto usgiz;
		LnEbd:goto lRiDz;
		goto eEGUb;
		MPNBX:return $currency;
		goto aLe51;
		aLe51:
	}
}


goto f6y_f;
uVqYj:
if (!function_exists("group_test_calculations")) {
	function group_test_calculations($id)
	{
		goto CEJ1v;
		rJ0jK:
		if (!isset($group["doctor"])) {
			goto YSCVb;
		}
		goto N4Rqq;
		EXXbg:
		if (!isset($group["packages"])) {
			goto L2nzd;
		}
		goto hqpwq;
		ebvVJ:
		if (!isset($group["cultures"])) {
			goto wKstp;
		}
		goto pnSo9;
		N4Rqq:$doctor_commission = $total * $group["doctor"]["commission"] / 100;
		goto frXuo;
		hZDLC:
		foreach ($group["payments"] as $payment) {
			$paid += $payment["amount"];
			rhzqz:
		}
		goto d7XzE;
		PksGs:Po5jh:goto w3XDG;
		hqpwq:
		foreach ($group["packages"] as $package) {
			$subtotal += $package["price"];
			BNBsE:
		}
		goto PksGs;
		sHSlx:
		if (!count($group["payments"])) {
			goto KnSDF;
		}
		goto hZDLC;
		daDF5:
		if (!isset($group["tests"])) {
			goto PwrfP;
		}
		goto wQl9B;
		d7XzE:ESAsN:goto pml5q;
		frXuo:YSCVb:goto W9e0z;
		d7JTP:$subtotal = 0;
		goto mOkVr;
		wQl9B:
		foreach ($group["tests"] as $test) {
			$subtotal += $test["price"];
			MWLF9:
		}
		goto qxcL4;
		w3XDG:L2nzd:goto sHSlx;
		zFcCa:URmio:goto yukWI;
		qxcL4:RzARZ:goto ca3Er;
		yukWI:wKstp:goto EXXbg;
		pnSo9:
		foreach ($group["cultures"] as $culture) {
			$subtotal += $culture["price"];
			twdDa:
		}
		if($group["rays"]){
			foreach ($group["rays"] as $ray) {
				$subtotal += $ray["price"];
			}
		}
		goto zFcCa;
		mOkVr:$paid = 0;
		goto N6X8v;
		pml5q:KnSDF:goto stk_r;
		W9e0z:$group->update(
			[
				"subtotal" => round($subtotal,0),
				"discount" => $group["discount"], "total" => $total, "paid" => $paid, "due" => $due,
				"doctor_commission" => $doctor_commission
			]
		);
		goto ghwJi;
		Mz7cI:$due = $total - $paid;
		goto rJ0jK;
		N6X8v:$doctor_commission = 0;
		goto daDF5;
		ca3Er:PwrfP:goto ebvVJ;
		//stk_r:$total = $subtotal - $group["discount"];
//		stk_r:$total = $subtotal - ( $subtotal * $group["discount"] ) / 100;
		stk_r:$total = $group['total'];
		goto Mz7cI;
		CEJ1v:$group = Group::with("tests", "cultures", "contract")->where("id", $id)->first();
		goto d7JTP;
		ghwJi:
	}
}
goto KPbPW;
VaRPL:
if (!function_exists("get_system_date")) {
	function get_system_date($date = '', $format = '')
	{
		goto VCLnb;
		jILg5:wxKYa:goto QUW2f;
		GuUlL:T14VR:goto s_HY6;
		VCLnb:
		if (empty($date)) {
			goto T14VR;
		}
		goto rkfZP;
		QUW2f:return date("Y-m-d", strtotime($date));
		goto GuUlL;
		agPQD:return date("Y-m-d");
		goto dmFTw;
		WnaKt:return date($format, strtotime($date));
		goto jILg5;
		s_HY6:
		if (empty($format)) {
			goto pIlwH;
		}
		goto ZW3Ku;
		hZVbe:pIlwH:goto agPQD;
		rkfZP:
		if (empty($format)) {
			goto wxKYa;
		}
		goto WnaKt;
		ZW3Ku:return date($format);
		goto hZVbe;
		dmFTw:
	}
}
goto YZPDx;
f6y_f:
if (!function_exists("send_sms")) {
	function send_sms($to, $message)
	{
		goto r6klj;
		eM42o:goto SYqb2;
		goto sqEAI;
		pHxLg:$data = array(
			"apikey" => $apiKey, "numbers" => $numbers, "sender" => $sender,
			"message" => $message
		);
		goto qQAUa;
		K0k4x:$token = $sms_setting["token"];
		goto mil7k;
		mil7k:$client = new \Twilio\Rest\Client($sid, $token);
		goto cGzVc;
		npQyZ:curl_close($ch);
		goto eM42o;
		Ug9V5:$response = curl_exec($curl);
		goto MTnMU;
		BSEj3:$numbers = array($to);
		goto ER7aH;
		BJSZM:$apiKey = urlencode($sms_setting["localText"]["key"]);
		goto BSEj3;
		Pdfxm:goto SYqb2;
		goto fkr_i;
		fkr_i:UNm4x:goto BJSZM;
		RqX0e:goto SYqb2;
		goto QQdUa;
		DwYHg:SYqb2:goto cRCVX;
		IvinG:goto SYqb2;
		goto tFb2y;
		hc4TD:W1xEZ:goto Pdfxm;
		tFb2y:QEQ86:goto mlu9c;
		r6klj:$sms_setting = setting("sms");
		goto U4y2U;
		mlu9c:
		if (!(!empty($sms_setting["twilio"]["sid"]) && !empty($sms_setting["twilio"]["token"]) && !empty($sms_setting["twilio"]["from"]))) {
			goto W1xEZ;
		}
		goto eJ0at;
		pV2Wv:curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		goto Qw3Pz;
		ER7aH:$sender = urlencode($sms_setting["localText"]["sender"]);
		goto Rj74b;
		cGzVc:
		try {
			$client->messages->create($to, ["from" => $sms_setting["from"], "body" => $message]);
		} catch (\Exception $e) {}
		goto hc4TD;
		qQAUa:$ch = curl_init("https://api.textlocal.in/send/");
		goto sJ84w;
		g96i8:$curl = curl_init();
		goto Wzp0a;
		Rj74b:$message = rawurlencode($message);
		goto nzjyS;
		sen00:
		if ($sms_setting["gateway"] == "infobip" && !empty($sms_setting["infobip"]["base_url"]) && !empty($sms_setting["infobip"]["from"]) && !empty($sms_setting["infobip"]["key"])) {
			goto A3ewq;
		}
		goto RqX0e;
		x8rSY:curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		goto pV2Wv;
		Wzp0a:curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => $sms_setting["infobip"]["base_url"] . "/sms/2/text/advanced", CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '', CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST", CURLOPT_POSTFIELDS => '{"messages":[{"from":"" . $sms_setting["infobip"]["from"] . "","destinations":[{"to":"" . $to . ""}],"text":"" . $message . ""}]}',
				CURLOPT_HTTPHEADER => array(
					"Authorization: App " . $sms_setting["infobip"]["key"],
					"Content-Type: application/json",
					"Accept: application/json"
				)
			)
		);
		goto Ug9V5;
		WEabR:$basic = new \Vonage\Client\Credentials\Basic($sms_setting["nexmo"]["key"], $sms_setting["nexmo"]["secret"]);
		goto fHSH_;
		Ce8pn:
		if ($sms_setting["gateway"] == "twilio") {
			goto QEQ86;
		}
		goto kt_97;
		Qw3Pz:$response = curl_exec($ch);
		goto npQyZ;
		sJ84w:curl_setopt($ch, CURLOPT_POST, true);
		goto x8rSY;
		kt_97:
		if ($sms_setting["gateway"] == "localText" && !empty($sms_setting["localText"]["key"]) && !empty($sms_setting["localText"]["sender"])) {
			goto UNm4x;
		}
		goto sen00;
		yuQz9:$response = $client->sms()->send(new \Vonage\SMS\Message\SMS($to, BRAND_NAME, $message));
		goto qedYH;
		nm0zz:
		if (!(!empty($sms_setting["nexmo"]["key"]) && !empty($sms_setting["nexmo"]["secret"]))) {
			goto jcDVx;
		}
		goto WEabR;
		QQdUa:FiIF3:goto nm0zz;
		qedYH:jcDVx:goto IvinG;
		sqEAI:A3ewq:goto g96i8;
		fHSH_:$client = new \Vonage\Client($basic);
		goto yuQz9;
		MTnMU:curl_close($curl);
		goto DwYHg;
		eJ0at:$sid = $sms_setting["sid"];
		goto K0k4x;
		nzjyS:$numbers = implode(",", $numbers);
		goto pHxLg;
		U4y2U:
		if ($sms_setting["gateway"] == "nexmo") {
			goto FiIF3;
		}
		goto Ce8pn;
		cRCVX:
	}
}
goto nLE1r;
UY3An:
if (!function_exists("check_group_done")) {
	function check_group_done($group_id)
	{
		goto Um1s2;
		tuhqs:$done = true;
		goto jyVPA;
		mjkzI:$group->update(["done" => $done]);
		goto Hc_sE;
		DdeLw:
		foreach ($group["all_cultures"] as $culture) {
			goto mdEwS;
			A_b0G:ptnFU:goto VqgdG;
			VqgdG:JJzbe:goto LH1wf;
			LsoXd:$done = false;
			goto A_b0G;
			mdEwS:
			if ($culture["done"]) {
				goto ptnFU;
			}
			goto LsoXd;
			LH1wf:
		}
		goto O10dO;
		g6BbI:SdsAG:goto DdeLw;
		AXTX2:WaHu9:goto mjkzI;
		O10dO:dMBm6:goto AXTX2;
		SRi0Z:
		foreach ($group["all_tests"] as $test) {
			goto IhbW7;
			GymfO:$done = false;
			goto UQrek;
			UQrek:dWIHQ:goto AdH2D;
			AdH2D:KKO6V:goto H4Xgx;
			IhbW7:
			if ($test["done"]) {
				goto dWIHQ;
			}
			goto GymfO;
			H4Xgx:
		}
		goto g6BbI;
		Um1s2:$group = Group::with(["tests", "cultures"])->where("id", $group_id)->first();
		goto tuhqs;
		jyVPA:
		if (!isset($group)) {
			goto WaHu9;
		}
		goto SRi0Z;
		Hc_sE:return $done;
		goto inCDV;
		inCDV:
	}
}
goto uVqYj;
hZZcX:
if (!function_exists("whatsapp_notification")) {
	function whatsapp_notification($group, $type)
	{
		goto LAJBj;
		ve4lW:$url = "https://wa.me/" . $group["patient"]["phone"] . "?text=" . $message;
		goto Rsisb;
		Rsisb:return $url;
		goto xTU3l;
		AJINi:$url = "https://wa.me/" . $group["patient"]["phone"] . "?text=" . $message;
		goto uI249;
		lahyX:goto HdCiL;
		goto tGhGy;
		uI249:return $url;
		goto wipQs;
		OxlF8:$message = str_replace(
			["{patient_name}", "{report_link}"],
			[$group["patient"]["name"], $group["report_pdf"]],
			$whatsapp["report"]["message"]
		);
		goto ve4lW;
		WcM0q:
		if ($type == "report") {
			goto ag4b3;
		}
		goto lahyX;
		wipQs:goto HdCiL;
		goto k7qxL;
		zpH_t:
		if ($type == "receipt") {
			goto Rxm32;
		}
		goto WcM0q;
		vYmbB:$message = str_replace(
			["{patient_name}", "{receipt_link}"],
			[$group["patient"]["name"], $group["receipt_pdf"]],
			$whatsapp["receipt"]["message"]
		);
		goto AJINi;
		LAJBj:$whatsapp = setting("whatsapp");
		goto zpH_t;
		k7qxL:ag4b3:goto OxlF8;
		xTU3l:HdCiL:goto exPd3;
		tGhGy:Rxm32:goto vYmbB;
		exPd3:
	}
}


function get_custody_branch(){
	return Branches_custody::where('status',1)->where('branche_id',session('branch_id'))->where('custody_type','>',0)->sum('custody') - Branches_custody::where('status',1)->where('branche_id',session('branch_id'))->where('custody_type',0)->sum('custody') ;
}

function get_cash_vault($date = null , $branch = null){
	$date = ($date == null) ? get_system_date() : $date;
	$branch = ($branch == null) ? session('branch_id') : $branch;
	$groups =  GroupPayment::whereHas('group', function($q)use($branch){
					return $q->where('branch_id',$branch);
				})
				->whereDate('date',$date)
				->where('payment_method_id','1')
				->sum('amount');
	
	$vault = Cash_in_vault::with('payments')->where('branche_id',$branch)
							->whereDate('created_at',$date)
							->first();

	$custody = Branches_custody::where('branche_id',$branch)
								->where('custody_type',2)
								->where('status','1')
								->whereDate('created_at',$date)
								->sum('custody');
	
	$cach = (isset($vault))?  $vault->payments->where('payment_method_id','1')->where('vault_type','0')->sum('amount') : 0;

	return ($groups + $cach) - $custody ;
}
function get_visa_vault(){
	$groups =  GroupPayment::whereHas('group', function($q){
					return $q->where('branch_id',session('branch_id'));
				})
				->whereDate('date',get_system_date())
				->where('payment_method_id','4')
				->sum('amount');

	$vault = Cash_in_vault::with('payments')->where('branche_id',session('branch_id'))
							->whereDate('created_at',get_system_date())
							->first();
	
	$cach = (isset($vault))?  $vault->payments->where('payment_method_id','4')->where('vault_type','0')->sum('amount') : 0;

	return $groups + $cach;
}

function get_payments_income($from,$to,$branchId,$payment_method_id)
{
	return ($from==$to)? 
		GroupPayment::whereHas('group', function($q)use($branchId){
		return $q->where('branch_id',$branchId);
		})->whereDate('date',$from)
		->where('payment_method_id',$payment_method_id)
		->sum('amount')
		:
		GroupPayment::whereHas('group', function($q)use($branchId){
			return $q->where('branch_id',$branchId);
		})->whereBetween('date',[$from,$to])
		->where('payment_method_id',$payment_method_id)
		->sum('amount')
		;
}
function get_payments_cach($branchCustody,$from,$to,$branchId)
{
	    $payment = ($from==$to)? 
		GroupPayment::whereHas('group', function($q)use($branchId){
		return $q->where('branch_id',$branchId);
		})->whereDate('date',$from)
		->where('payment_method_id','1')
		->sum('amount')
		:
		GroupPayment::whereHas('group', function($q)use($branchId){
			return $q->where('branch_id',$branchId);
		})->whereBetween('date',[$from,$to])
		->where('payment_method_id','1')
		->sum('amount')
		;

		return  $payment - $branchCustody ; 
}

function get_currency()
{
	return setting("info")['currency']; 
}


