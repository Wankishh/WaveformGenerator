<?php

namespace App\Models;

enum ChannelTypes: string
{
	case SilenceStart = "silence_start";
	case SilenceEnd = "silence_end";
}
