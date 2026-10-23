# swap key pressed while holding Glutbart
function mythic:util/swapback
tag @s add mythic.caster
execute if predicate mythic:sneaking run function mythic:active/glutbart/try2
execute unless predicate mythic:sneaking run function mythic:active/glutbart/try1
tag @s remove mythic.caster
