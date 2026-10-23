# Sternenregen: Sterne stürzen auf dein Ziel (bis 32 Blöcke): 8 Schaden im Umkreis von 3,5 Blöcken.
function mythic:util/ray
execute at @e[type=minecraft:marker,tag=mythic.hit,limit=1] run function mythic:active/sternenspeer/impact
kill @e[type=minecraft:marker,tag=mythic.hit]
