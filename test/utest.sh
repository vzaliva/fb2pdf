#!/bin/sh

FB2FILES="*.fb2"
PDFLATEXFLAGS="-halt-on-error -interaction batchmode -no-shell-escape"
FB2TEX=../scripts/fb2tex
rm -f *.pdf enc* *.out *.dvi *.ps *.log *.toc *.aux *.tex *.fblog

PYTHONPATH=../src/
export PYTHONPATH

rsync -avz --exclude=".svn"  ../src/TeX/ ./


TEXFAILED=""
PDFFAILED=""
PASSED=""
for i in ${FB2FILES}; do
    N=`basename $i .fb2`
    t=${N}.tex
    echo $N
    python ${FB2TEX} -v -f $i -o $t > $N.fblog 2>&1
    if [ $? -ne 0 ]; then
        TEXFAILED="${TEXFAILED} $i"
    else
        p=${N}.pdf
        #pdflatex ${PDFLATEXFLAGS} $t $p > /dev/null $2>1
        pdflatex ${PDFLATEXFLAGS} $t $p 
        if [ $? -ne 0 ]; then
            PDFFAILED="${PDFFAILED} $i"
        else
            pdflatex ${PDFLATEXFLAGS} $t $p > /dev/null $2>1
            if [ $? -ne 0 ]; then
                PDFFAILED="${PDFFAILED} $i"
            else
                # TODO: pdfopt
                PASSED="${PASSED} $i"
            fi
        fi
    fi
done

echo "Passed:"
for i in ${PASSED}; do
    echo "+ $i"
done

echo "FB2PDF Failed:"
for i in ${TEXFAILED}; do
    echo "- $i"
done

echo "PDFLATEX Failed:"
for i in ${PDFFAILED}; do
    echo "- $i"
done


