# Gewittersturm: Drei Blitze schlagen um dein Ziel ein (bis 32 Blöcke).
function mythic:util/ray
execute at @e[type=minecraft:marker,tag=mythic.hit,limit=1] run function mythic:active/abyssdreizack/impact
kill @e[type=minecraft:marker,tag=mythic.hit]
