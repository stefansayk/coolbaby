# swap key pressed while holding Sternenspeer
function mythic:util/swapback
tag @s add mythic.caster
execute if predicate mythic:sneaking run function mythic:active/sternenspeer/try2
execute unless predicate mythic:sneaking run function mythic:active/sternenspeer/try1
tag @s remove mythic.caster
