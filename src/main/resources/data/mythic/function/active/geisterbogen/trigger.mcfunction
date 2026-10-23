# swap key pressed while holding Geisterbogen
function mythic:util/swapback
tag @s add mythic.caster
execute if predicate mythic:sneaking run function mythic:active/geisterbogen/try2
execute unless predicate mythic:sneaking run function mythic:active/geisterbogen/try1
tag @s remove mythic.caster
