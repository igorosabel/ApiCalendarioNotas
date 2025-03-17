<?php if (is_null($entry)): ?>
null
<?php else: ?>
{
	"id": {{ entry.id }},
	"day": {{ entry.day }},
	"month": {{ entry.month }},
	"year": {{ entry.year }},
	"order": {{ entry.order }},
	"title": {{ entry.title | string }},
	"content": {{ entry.content | string }},
	"check": {{ entry.check | bool }},
	"checked": {{ entry.checked | bool }},
	"shared": {{ entry.shared | bool }},
	"idOriginal": {{ entry.id_original | number }}
}
<?php endif ?>
