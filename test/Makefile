# Makefile 

allfb := $(wildcard *.fb2)
allpdf := $(patsubst %.fb2,%.pdf,$(wildcard *.fb2))
alltex := $(patsubst %.fb2,%.tex,$(wildcard *.fb2))

PDFLATEXFLAGS = 

all: $(allpdf)

texfiles: $(alltex)

%.pdf: %.tex
	pdflatex $(PDFLATEXFLAGS) $<
	pdflatex $(PDFLATEXFLAGS) $<

%.tex: %.fb2
	python `which fb2tex` -v -f $< -o $@

install:
	cd .. && sudo python setup.py install; cd test

test:
	./utest.sh

clean:
	rm -f *.pdf enc* *.out *.dvi *.ps *.log *.toc *.aux *.tex *.fblog
