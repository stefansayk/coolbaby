# swap key pressed while holding Tiefseejäger
function mythic:util/swapback
tag @s add mythic.caster
execute if predicate mythic:sneaking run function mythic:active/tiefseejaeger/try2
execute unless predicate mythic:sneaking run function mythic:active/tiefseejaeger/try1
tag @s remove mythic.caster
