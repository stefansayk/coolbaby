# runs at the target point of Sternenregen
tag @e[type=!#mythic:not_target,tag=!mythic.caster,distance=..3.5] add mythic.t
execute as @e[tag=mythic.t] run damage @s 8 minecraft:magic by @p[tag=mythic.caster]
effect give @e[tag=mythic.t] minecraft:glowing 6 0
particle minecraft:end_rod ~ ~5 ~ 1.5 3 1.5 0.02 150
particle minecraft:firework ~ ~0.5 ~ 1.5 0.3 1.5 0.15 60
playsound minecraft:entity.firework_rocket.large_blast player @a ~ ~ ~ 2 0.8
playsound minecraft:block.amethyst_block.resonate player @a ~ ~ ~ 2 0.6
tag @e[tag=mythic.t] remove mythic.t
