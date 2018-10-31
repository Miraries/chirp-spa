<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Matriphe\Larinfo\LarinfoFacade;

class LarinfoController extends Controller
{
	public function show()
	{
		return ['host' => LarinfoFacade::getHostIpinfo(),
				'client' => LarinfoFacade::getClientIpinfo(),
				'software' => LarinfoFacade::getServerInfoSoftware(),
				'uptime' => LarinfoFacade::getUptime(),
				'db' => LarinfoFacade::getDatabaseInfo()
		];
	}
}
