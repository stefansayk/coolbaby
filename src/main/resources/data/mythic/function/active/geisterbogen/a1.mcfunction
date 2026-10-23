# Geisterregen: Ein Pfeilhagel stürzt auf dein Ziel (bis 32 Blöcke).
function mythic:util/ray
execute at @e[type=minecraft:marker,tag=mythic.hit,limit=1] run function mythic:active/geisterbogen/impact
kill @e[type=minecraft:marker,tag=mythic.hit]
