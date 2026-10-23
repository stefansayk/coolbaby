# Seelenernte: Rote Seelenwelle: 6 Schaden an allen Gegnern im Umkreis von 6 Blöcken, sie verdorren, du regenerierst.
tag @e[type=!#mythic:not_target,tag=!mythic.caster,distance=..6] add mythic.t
execute as @e[tag=mythic.t] run damage @s 6 minecraft:magic by @p[tag=mythic.caster]
effect give @e[tag=mythic.t] minecraft:wither 5 1
effect give @s minecraft:regeneration 4 2
particle minecraft:soul ~ ~0.5 ~ 3 0.4 3 0.05 120
particle minecraft:damage_indicator ~ ~1 ~ 3 0.5 3 0.2 30
playsound minecraft:entity.wither.shoot player @a ~ ~ ~ 1 0.7
playsound minecraft:particle.soul_escape player @a ~ ~ ~ 1 0.6
tag @e[tag=mythic.t] remove mythic.t
