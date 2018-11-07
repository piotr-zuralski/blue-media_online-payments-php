#!/usr/bin/env sh

# Piotr Żuralski <piotr@zuralski.net>
# copyright 2015 zuralski.net

_pwd=$(pwd -P);
if [[ ${_pwd} == */bin ]]; then
    cd ../;
    _pwd=$(pwd -P);
fi

projectHooksDir=${_pwd}/.config/git/hooks/;
gitHooksDir=${_pwd}/.git/hooks/;

mkdir -p builds/

function makeHookSymlink {
    if [ "$1" ]; then
        hook=$1;
    fi
    cd ${gitHooksDir};
    echo -e 'making symlink for "'${hook}'"';
    ln -s ${projectHooksDir}${hook} ${gitHooksDir}${hook};
};

for hook in $(ls -a ${projectHooksDir})
do
    # checks if file really exists
    if [ -f ${projectHooksDir}${hook} ]; then

        # checks if there's already a symlink to .git/hooks
        if [[ ! -L ${gitHooksDir}${hook} ]]; then

            # if the hook is a single file, remove it
            if [[ -f ${gitHooksDir}${hook} ]]; then
                echo -e 'removing "'${hook}'"';
                unlink ${gitHooksDir}${hook};
                makeHookSymlink ${hook};

            # hook doesn't exsists
            else
                makeHookSymlink ${hook};
            fi

        # checks if there's already a symlink to .git/hooks
        else
            # verify if sile is exacly the same
            hookDiff=$(diff ${projectHooksDir}${hook} ${gitHooksDir}${hook} 2>&1);

            # file is different from original, remove it
            if [[ ! ${hookDiff} == '' ]]; then
                echo -e 'hook differs, removing "'${hook}'"';
                unlink ${gitHooksDir}${hook};
                makeHookSymlink ${hook};
            fi
        fi
    fi
done

composer=`command -v composer`;
if [[ ! ${composer} || ! -f ${composer} ]]; then
    curl -sS https://getcomposer.org/installer | php -- --install-dir=`pwd`/bin --filename=composer;
    composer="./bin/composer.phar";
fi

if [ ${composer} ]; then
    ${composer} self-update;
    ${composer} install;
fi

${composer} outdated -D

./bin/phing -k > builds/build.log 2>&1;
echo -e 'done build';
